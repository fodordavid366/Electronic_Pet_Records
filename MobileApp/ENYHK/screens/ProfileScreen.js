// screens/ProfileScreen.js
import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert, ScrollView, TouchableOpacity } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { API_BASE_URL } from '../config';


export default function ProfileScreen({ navigation }) {
  const [lastName, setLastName] = useState('');
  const [firstName, setFirstName] = useState('');
  const [phone, setPhone] = useState('');
  const [birthDate, setBirthDate] = useState('');
  const [originalData, setOriginalData] = useState({});

  const loadProfile = async () => {
    try {
      const token = await AsyncStorage.getItem('token');
      const response = await fetch(`${API_BASE_URL}/profile_update.php`, {
        method: 'GET',
        headers: { 'Authorization': 'Bearer ' + token }
      });
      const data = await response.json();

      if (data.message) {
        Alert.alert('Hiba', data.message);
        return;
      }

      setLastName(data.last_name || '');
      setFirstName(data.first_name || '');
      setPhone(data.phone_number || '');
      setBirthDate(data.birth_date || '');
      setOriginalData(data);
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', 'Hiba történt az adatok lekérésekor.');
    }
  };

  useEffect(() => {
    loadProfile();
  }, []);

  const handleReset = () => {
    setLastName(originalData.last_name || '');
    setFirstName(originalData.first_name || '');
    setPhone(originalData.phone_number || '');
    setBirthDate(originalData.birth_date || '');
  };

  const handleUpdate = async () => {
    // Validációk
    if (firstName.length > 40) { Alert.alert('Hiba', 'Keresztnév túl hosszú.'); return; }
    if (lastName.length > 40) { Alert.alert('Hiba', 'Vezetéknév túl hosszú.'); return; }
    if (!/^[0-9+\-\s]+$/.test(phone) || phone.length > 13) { Alert.alert('Hiba', 'Érvénytelen telefonszám.'); return; }
    const d = new Date(birthDate);
    if (isNaN(d.getTime()) || birthDate !== d.toISOString().split('T')[0]) {
      Alert.alert('Hiba', 'Érvénytelen születési dátum.');
      return;
    }

    try {
      const token = await AsyncStorage.getItem('token');
      const response = await fetch(`${API_BASE_URL}/profile_update.php`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
          first_name: firstName,
          last_name: lastName,
          phone_number: phone,
          birth_date: birthDate
        })
      });

      const result = await response.json();
      if (response.ok) {
        Alert.alert('Siker', 'Profil sikeresen frissítve!');
        setOriginalData({ first_name: firstName, last_name: lastName, phone_number: phone, birth_date: birthDate });
      } else {
        Alert.alert('Hiba', result.message || 'Hiba történt a frissítés során.');
      }
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', 'Hálózati hiba történt.');
    }

    
  };

  const handleLogout = async () => {
    try {
      await AsyncStorage.removeItem('token');
      navigation.replace('Login');
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', 'Nem sikerült kijelentkezni.');
    }
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.title}>Profil módosítás</Text>

      <TextInput placeholder="Vezetéknév" style={styles.input} value={lastName} onChangeText={setLastName} />
      <TextInput placeholder="Keresztnév" style={styles.input} value={firstName} onChangeText={setFirstName} />
      <TextInput placeholder="Telefonszám" style={styles.input} value={phone} onChangeText={setPhone} keyboardType="phone-pad" />
      <TextInput placeholder="Születési dátum (YYYY-MM-DD)" style={styles.input} value={birthDate} onChangeText={setBirthDate} />

      <Button title="Módosítás" onPress={handleUpdate} />
      <Button title="Visszaállítás" color="gray" onPress={handleReset} />

      <TouchableOpacity onPress={() => navigation.navigate('ForgotPassword')}>
        <Text style={styles.link}>Jelszó módosítás</Text>
      </TouchableOpacity>

      <Button title="Kijelentkezés" onPress={handleLogout} />
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { padding: 20, justifyContent: 'center' },
  title: { fontSize: 24, fontWeight: 'bold', marginBottom: 20, textAlign: 'center' },
  input: { borderWidth: 1, borderColor: '#ccc', borderRadius: 8, padding: 12, marginBottom: 15 },
  link: { color: '#007bff', textAlign: 'center', marginTop: 15, textDecorationLine: 'underline' }
});
