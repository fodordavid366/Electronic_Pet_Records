// screens/LoginScreen.js
import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { API_BASE_URL } from '../config';


export default function LoginScreen({ navigation }) {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async () => {
    if (!email || !password) {
      Alert.alert('Hiba', 'Töltsd ki az emailt és jelszót!');
      return;
    }

    try {
      const response = await fetch(`${API_BASE_URL}/login.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
      });

      const result = await response.json();

      if (response.ok) {
        // token mentése AsyncStorage-be
        await AsyncStorage.setItem('token', result.token);
        // reset a stack, hogy HomeScreen legyen az egyetlen
        navigation.replace('MainTabs');


      } else {
        Alert.alert('Hiba', result.message);
      }
    } catch (err) {
      console.error(err);
      Alert.alert('Hiba', 'Nem sikerült kapcsolódni az API-hoz.');
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Bejelentkezés</Text>
      <TextInput
        placeholder="Email"
        style={styles.input}
        value={email}
        onChangeText={setEmail}
        autoCapitalize="none"
        keyboardType="email-address"
      />
      <TextInput
        placeholder="Jelszó"
        style={styles.input}
        value={password}
        onChangeText={setPassword}
        secureTextEntry
      />
      <TouchableOpacity style={styles.button} onPress={handleLogin}>
        <Text style={styles.buttonText}>Bejelentkezés</Text>
      </TouchableOpacity>

      {/* Linkek */}
      <View style={styles.linksContainer}>
        <TouchableOpacity onPress={() => navigation.navigate('ForgotPassword')}>
          <Text style={styles.linkText}>Elfelejtett jelszó?</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => navigation.navigate('Register')}>
          <Text style={styles.linkText}>Regisztráció</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, justifyContent: 'center', alignItems: 'center', padding: 20 },
  title: { fontSize: 28, marginBottom: 20, fontWeight: 'bold' },
  input: { width: '100%', padding: 15, borderWidth: 1, borderColor: '#ccc', borderRadius: 8, marginBottom: 15 },
  button: { backgroundColor: '#007bff', padding: 15, borderRadius: 8, width: '100%' },
  buttonText: { color: 'white', textAlign: 'center', fontWeight: 'bold' },
  linksContainer: { marginTop: 15, alignItems: 'center' },
  linkText: { color: '#007bff', textDecorationLine: 'underline', marginVertical: 5 }
});
