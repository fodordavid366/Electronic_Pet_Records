// screens/MyPetsScreen.js
import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, Button, Alert, StyleSheet, Image, ScrollView, TouchableOpacity, Linking } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { API_BASE_URL } from '../config';

export default function MyPetsScreen() {
  const [token, setToken] = useState(null);
  const [pets, setPets] = useState([]);
  const [currentPetId, setCurrentPetId] = useState(null);

  const [name, setName] = useState('');
  const [gender, setGender] = useState('');
  const [birthDate, setBirthDate] = useState('');
  const [species, setSpecies] = useState('');
  const [breed, setBreed] = useState('');
  const [doctorId, setDoctorId] = useState(0);
  const [doctors, setDoctors] = useState([]);

  const [qrUrl, setQrUrl] = useState('');

  useEffect(() => {
    const loadToken = async () => {
      const t = await AsyncStorage.getItem('token');
      if (!t) {
        Alert.alert('Hiba', 'Nincs bejelentkezve!');
        return;
      }
      setToken(t);
    };
    loadToken();
  }, []);

  useEffect(() => {
    if (token) {
      fetchPets();
      fetchDoctors();
    }
  }, [token]);

  const fetchPets = async () => {
    try {
      const res = await fetch(`${API_BASE_URL}/pets.php`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      if (!res.ok) throw new Error('Hiba a kisállatok betöltésekor');
      const data = await res.json();
      setPets(data);
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', err.message);
    }
  };

  const fetchDoctors = async () => {
    try {
      const res = await fetch(`${API_BASE_URL}/vets.php`);
      if (!res.ok) throw new Error('Hiba az orvosok betöltésekor');
      const data = await res.json();
      setDoctors([{ vet_id: 0, name: 'Válasszon doktort' }, ...data.map(d => ({ vet_id: d.vet_id, name: d.first_name + ' ' + d.last_name }))]);
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', err.message);
    }
  };

  const selectPet = (petId) => {
    if (petId === 'new') {
      setCurrentPetId(null);
      setName('');
      setGender('');
      setBirthDate('');
      setSpecies('');
      setBreed('');
      setDoctorId(0);
      setQrUrl('');
    } else {
      const pet = pets.find(p => String(p.pet_id) === petId);
      if (pet) {
        setCurrentPetId(pet.pet_id);
        setName(pet.name);
        setGender(pet.gender);
        setBirthDate(pet.birth_date);
        setSpecies(pet.species);
        setBreed(pet.breed);
        setDoctorId(pet.vet_id || 0);
        setQrUrl(`${API_BASE_URL}/generate_qr.php?pet_id=${pet.pet_id}`);
      }
    }
  };

  const savePet = async () => {
    if (!name || !gender || !birthDate || !species || !breed || doctorId === 0) {
      Alert.alert('Hiba', 'Minden mező kitöltése kötelező!');
      return;
    }

    const payload = {
      pet_id: currentPetId,
      name,
      gender,
      birth_date: birthDate,
      species,
      breed,
      vet_id: doctorId
    };

    const method = currentPetId ? 'PUT' : 'POST';
    try {
      const res = await fetch(`${API_BASE_URL}/pets.php`, {
        method,
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${token}`
        },
        body: JSON.stringify(payload)
      });
      const data = await res.json();
      Alert.alert(data.message || 'Ismeretlen hiba');
      if (res.ok) {
        await fetchPets();
        if (!currentPetId && data.pet_id) setCurrentPetId(data.pet_id);
      }
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', 'Nem sikerült menteni');
    }
  };

  const deletePet = async () => {
    if (!currentPetId) return;
    Alert.alert('Megerősítés', 'Biztosan törölni szeretnéd?', [
      { text: 'Mégse', style: 'cancel' },
      {
        text: 'Törlés',
        style: 'destructive',
        onPress: async () => {
          try {
            const res = await fetch(`${API_BASE_URL}/pets.php?pet_id=${currentPetId}`, {
              method: 'DELETE',
              headers: { Authorization: `Bearer ${token}` }
            });
            const data = await res.json();
            Alert.alert(data.message || 'Ismeretlen hiba');
            if (res.ok) {
              selectPet('new');
              fetchPets();
            }
          } catch (err) {
            console.error(err);
            Alert.alert('Hiba', 'Nem sikerült törölni');
          }
        }
      }
    ]);
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.title}>Kisállataim</Text>

      <Text>Kisállat</Text>
      <Picker selectedValue={currentPetId || 'new'} onValueChange={selectPet} style={styles.picker}>
        <Picker.Item label="Új kisállat hozzáadása" value="new" />
        {pets.map(p => <Picker.Item key={p.pet_id} label={p.name} value={String(p.pet_id)} />)}
      </Picker>

      <Text>Név</Text>
      <TextInput style={styles.input} value={name} onChangeText={setName} />

      <Text>Nem</Text>
      <TextInput style={styles.input} value={gender} onChangeText={setGender} />

      <Text>Születési dátum</Text>
      <TextInput style={styles.input} value={birthDate} onChangeText={setBirthDate} placeholder="YYYY-MM-DD" />

      <Text>Faj</Text>
      <TextInput style={styles.input} value={species} onChangeText={setSpecies} />

      <Text>Fajta</Text>
      <TextInput style={styles.input} value={breed} onChangeText={setBreed} />

      <Text>Válasszon doktort</Text>
      <Picker selectedValue={doctorId} onValueChange={setDoctorId} style={styles.picker}>
        {doctors.map(d => <Picker.Item key={d.vet_id} label={d.name} value={d.vet_id} />)}
      </Picker>

      <Button title="Mentés" onPress={savePet} />
      {currentPetId && <Button title="Törlés" color="red" onPress={deletePet} />}

      {qrUrl ? (
        <View style={{ alignItems: 'center', marginTop: 20 }}>
          <TouchableOpacity style={styles.downloadBtn} onPress={() => Linking.openURL(qrUrl)}>
            <Image source={{ uri: qrUrl }} style={{ width: 150, height: 150 }}/>
          </TouchableOpacity>
        </View>
      ) : null}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { padding: 20 },
  title: { fontSize: 24, fontWeight: 'bold', textAlign: 'center', marginBottom: 20 },
  input: { borderWidth: 1, borderColor: '#ccc', padding: 10, marginBottom: 15, borderRadius: 5 },
  picker: { borderWidth: 1, borderColor: '#ccc', marginBottom: 15 },
  downloadBtn: { marginTop: 10, backgroundColor: '#007bff', padding: 10, borderRadius: 5 }
});
