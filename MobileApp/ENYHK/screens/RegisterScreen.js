import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, Alert, ScrollView, StyleSheet } from 'react-native';
import { API_BASE_URL } from '../config';


export default function RegisterScreen({ navigation }) {
  const [firstname, setFirstname] = useState('');
  const [lastname, setLastname] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordVerify, setPasswordVerify] = useState('');
  const [phone, setPhone] = useState('');
  const [birthDate, setBirthDate] = useState('');

  const handleRegister = async () => {
    // Input validation
    if (!firstname || !lastname || !email || !password || !passwordVerify || !phone || !birthDate) {
      Alert.alert('Hiba', 'Kérjük, töltse ki az összes mezőt!');
      return;
    }

    try {
      const response = await fetch(`${API_BASE_URL}/register.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          firstname,
          lastname,
          email,
          password,
          password_verify: passwordVerify,
          phone,
          birth_date: birthDate,
        }),
      });

      const result = await response.json();

      if (response.ok) {
        Alert.alert('Siker', result.message, [
          { text: 'OK', onPress: () => navigation.navigate('Login') }
        ]);
      } else {
        Alert.alert('Hiba', result.message);
      }
    } catch (error) {
      console.error(error);
      Alert.alert('Hiba', 'Nem sikerült kapcsolódni a szerverhez.');
    }
  };

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.title}>Regisztráció</Text>

      <TextInput placeholder="Vezetéknév" style={styles.input} value={lastname} onChangeText={setLastname} />
      <TextInput placeholder="Keresztnév" style={styles.input} value={firstname} onChangeText={setFirstname} />
      <TextInput placeholder="Email" style={styles.input} value={email} onChangeText={setEmail} keyboardType="email-address" />
      <TextInput placeholder="Jelszó" style={styles.input} value={password} onChangeText={setPassword} secureTextEntry />
      <TextInput placeholder="Jelszó megerősítés" style={styles.input} value={passwordVerify} onChangeText={setPasswordVerify} secureTextEntry />
      <TextInput placeholder="Telefonszám" style={styles.input} value={phone} onChangeText={setPhone} keyboardType="phone-pad" />
      <TextInput placeholder="Születési dátum (YYYY-MM-DD)" style={styles.input} value={birthDate} onChangeText={setBirthDate} />

      <TouchableOpacity style={styles.button} onPress={handleRegister}>
        <Text style={styles.buttonText}>Regisztráció</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    padding: 20,
    justifyContent: 'center',
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    marginBottom: 20,
    alignSelf: 'center',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    padding: 12,
    borderRadius: 6,
    marginBottom: 15,
  },
  button: {
    backgroundColor: '#3D405B',
    padding: 15,
    borderRadius: 6,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
});
