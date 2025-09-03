import React, { useEffect, useState } from 'react';
import { View, Text, Button, Alert, ScrollView, TouchableOpacity, Platform } from 'react-native';
import DateTimePicker from '@react-native-community/datetimepicker';
import { Picker } from '@react-native-picker/picker';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { API_BASE_URL } from '../config';
import * as Notifications from 'expo-notifications';


export default function ReservationScreen() {
  const [pets, setPets] = useState([]);
  const [treatments, setTreatments] = useState([]);
  const [selectedPet, setSelectedPet] = useState('');
  const [selectedTreatment, setSelectedTreatment] = useState('');
  const [date, setDate] = useState(new Date());
  const [showDatePicker, setShowDatePicker] = useState(false);
  const [slots, setSlots] = useState([]);
  const [selectedSlot, setSelectedSlot] = useState('');

  const getToken = async () => await AsyncStorage.getItem('token');


  useEffect(() => {
  registerForPushNotificationsAsync();
  loadPets();
  loadTreatments();
}, []);

const registerForPushNotificationsAsync = async () => {
  const { status } = await Notifications.requestPermissionsAsync();
  if (status !== 'granted') {
    Alert.alert('Hiba', 'Az értesítések engedélyezése szükséges a funkcióhoz.');
  }
};

const scheduleNotification = async (dateTime) => {
  // Értesítés időpontja = foglalás időpontja - 1 óra
  const triggerTime = new Date(dateTime.getTime() - 60 * 60 * 1000);

  // Ha az értesítés már elmúlt, ne állítsuk be
  if (triggerTime <= new Date()) return;

  await Notifications.scheduleNotificationAsync({
    content: {
      title: "Foglalás emlékeztető",
      body: `1 órád van hátra a foglalásodra: ${selectedPet ? pets.find(p => p.pet_id === selectedPet)?.name : ''}`,
      sound: true,
    },
    trigger: triggerTime,
  });
};



  const formatLocalDate = (d) => {
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
  };

  const loadPets = async () => {
    const token = await getToken();
    const res = await fetch(`${API_BASE_URL}/pets.php`, {
      headers: { Authorization: `Bearer ${token}` }
    });
    if (!res.ok) return Alert.alert('Hiba', 'Nem sikerült betölteni a házikedvenceket.');
    const data = await res.json();
    setPets(data);
  };

  const loadTreatments = async () => {
    const res = await fetch(`${API_BASE_URL}/treatments.php`);
    if (!res.ok) return Alert.alert('Hiba', 'Nem sikerült betölteni a kezeléseket.');
    const data = await res.json();
    setTreatments(data);
  };

  const onDateChange = (event, selected) => {
    setShowDatePicker(Platform.OS === 'ios'); // iOS-en maradjon nyitva
    if (selected) {
        setDate(selected);
        // Ha a dátum változik, töröljük az előző időpontokat és a kiválasztott slotot
        setSlots([]);
        setSelectedSlot('');
    }
};


  const generateSlots = async () => {
    // Előző időpontok törlése
    setSlots([]);
    setSelectedSlot('');

    if (!selectedPet || !selectedTreatment || !date) {
        return Alert.alert('Hiba', 'Töltsd ki az összes mezőt!');
    }

    const pet = pets.find(p => p.pet_id == selectedPet);
    const dateStr = formatLocalDate(date);

    const res = await fetch(`${API_BASE_URL}/appointments.php?action=slots&vet_id=${pet.vet_id}&date=${dateStr}&treatment_id=${selectedTreatment}`, {
        headers: { Authorization: `Bearer ${await getToken()}` }
    });

    if (!res.ok) {
        return Alert.alert('Hiba', 'Nincs elérhető időpont ezen a napon.');
    } 

    const data = await res.json();
    setSlots(data.available_slots || []);
};


  const bookSlot = async () => {
    if (!selectedSlot) return Alert.alert('Hiba', 'Válassz egy időpontot!');
    const pet = pets.find(p => p.pet_id == selectedPet);
    const dateStr = formatLocalDate(date);
    const payload = {
      pet_id: selectedPet,
      vet_id: pet.vet_id,
      treatment_id: selectedTreatment,
      starts_at: `${dateStr} ${selectedSlot}:00`,
      description: ""
    };
    const res = await fetch(`${API_BASE_URL}/appointments.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${await getToken()}` },
      body: JSON.stringify(payload)
    });
    const data = await res.json().catch(() => ({}));
    Alert.alert(data.message || 'Hiba történt');
    if (res.ok) {
      setSelectedPet('');
      setSelectedTreatment('');
      setDate(new Date());
      setSlots([]);
      setSelectedSlot('');

      const appointmentDate = new Date(`${dateStr}T${selectedSlot}:00`);
      scheduleNotification(appointmentDate);
    }
  };

  return (
    <ScrollView contentContainerStyle={{ padding: 20 }}>
      <Text style={{ fontSize: 24, marginBottom: 10 }}>Foglalás</Text>

      <Text>Kedvenc kiválasztása:</Text>
      <Picker selectedValue={selectedPet} onValueChange={setSelectedPet}>
        <Picker.Item label="Válassz egy házikedvencet" value="" />
        {pets.map(p => <Picker.Item key={p.pet_id} label={p.name} value={p.pet_id} />)}
      </Picker>

      <Text>Kezelet kiválasztása:</Text>
      <Picker selectedValue={selectedTreatment} onValueChange={setSelectedTreatment}>
        <Picker.Item label="Válassz kezelést" value="" />
        {treatments.map(t => (
          <Picker.Item key={t.treatment_id} label={`${t.name} (${t.duration_min} perc) (${t.cost} din)`} value={t.treatment_id} />
        ))}
      </Picker>

      <Text>Dátum:</Text>
      <TouchableOpacity onPress={() => setShowDatePicker(true)} style={{ padding: 10, backgroundColor: '#ddd', marginBottom: 10 }}>
        <Text>{date.toDateString()}</Text>
      </TouchableOpacity>
      {showDatePicker && (
        <DateTimePicker
          value={date}
          mode="date"
          display="default"
          minimumDate={new Date()}
          onChange={onDateChange}
        />
      )}

      <Button title="Időpontok generálása" onPress={generateSlots} />

      {slots.length > 0 && (
        <View style={{ marginVertical: 20 }}>
          <Text>Választható időpontok:</Text>
          {slots.map(s => (
            <TouchableOpacity key={s} onPress={() => setSelectedSlot(s)} style={{ padding: 10, backgroundColor: selectedSlot===s?'green':'#ccc', marginVertical: 2 }}>
              <Text style={{ color: selectedSlot===s?'white':'black' }}>{s}</Text>
            </TouchableOpacity>
          ))}
        </View>
      )}

      {selectedSlot && <Button title="Időpont foglalása" onPress={bookSlot} />}
    </ScrollView>
  );
}
