// screens/HomeScreen.js
import React, { useEffect, useState } from 'react';
import { View, Text, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { API_BASE_URL } from '../config';


export default function HomeScreen({ route, navigation }) {
  const [token, setToken] = useState(null);
  const [email, setEmail] = useState(route.params?.email || '');

  useEffect(() => {
    const loadToken = async () => {
      try {
        const storedToken = await AsyncStorage.getItem('token');
        if (storedToken) setToken(storedToken);
      } catch (err) {
        console.error(err);
        Alert.alert('Hiba', 'Nem sikerült betölteni a tokeneket.');
      }
    };
    loadToken();
  }, []);

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
    <View style={styles.container}>
      <Text style={styles.title}>Üdvözöllek!</Text>
      <Text style={styles.info}>Email: {email}</Text>
      <Text style={styles.info}>Token: {token || 'Nincs elmentve'}</Text>

      {/* Profil szerkesztés gomb */}
      <TouchableOpacity
        style={[styles.button, { backgroundColor: '#007bff' }]}
        onPress={() => navigation.navigate('Profile')}
      >
        <Text style={styles.buttonText}>Profil szerkesztése</Text>
      </TouchableOpacity>

      {/* Kijelentkezés */}
      <TouchableOpacity style={styles.button} onPress={handleLogout}>
        <Text style={styles.buttonText}>Kijelentkezés</Text>
      </TouchableOpacity>

      <TouchableOpacity
      style={[styles.button, { backgroundColor: '#28a745' }]}
      onPress={() => navigation.navigate('MyPets')}>
      <Text style={styles.buttonText}>Kisállataim</Text>
      </TouchableOpacity>

      <TouchableOpacity
      style={[styles.button, { backgroundColor: '#28a745' }]}
      onPress={() => navigation.navigate('MyReservations')}>
      <Text style={styles.buttonText}>Időpontjaim</Text>
      </TouchableOpacity>

    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, justifyContent: 'center', alignItems: 'center', padding: 20, backgroundColor: '#f5f5f5' },
  title: { fontSize: 24, fontWeight: 'bold', marginBottom: 20 },
  info: { fontSize: 16, marginBottom: 10 },
  button: { padding: 15, borderRadius: 8, marginTop: 20, width: '80%', alignItems: 'center' },
  buttonText: { color: 'white', fontWeight: 'bold' }
});
