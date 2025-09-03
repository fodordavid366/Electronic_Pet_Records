import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, Alert, StyleSheet } from 'react-native';
import { API_BASE_URL } from '../config';


export default function ForgotPasswordScreen({ navigation }) {
  const [email, setEmail] = useState('');

  const handleRequest = async () => {
    if (!email.trim()) {
      Alert.alert('Hiba', 'Adj meg egy email címet!');
      return;
    }

    try {
      const response = await fetch(`${API_BASE_URL}/forgot_password_request.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: email.trim() }),
      });

      const result = await response.json();

      if (response.ok) {
        Alert.alert('Siker', result.message);
      } else {
        Alert.alert('Hiba', result.message);
      }
    } catch (error) {
      console.error(error);
      Alert.alert('Hiba', 'Nem sikerült kapcsolódni a szerverhez.');
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Új jelszó kérése</Text>

      <TextInput
        placeholder="Email"
        style={styles.input}
        value={email}
        onChangeText={setEmail}
        keyboardType="email-address"
      />

      <TouchableOpacity style={styles.button} onPress={handleRequest}>
        <Text style={styles.buttonText}>Új jelszó kérése</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
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
    marginBottom: 10,
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
  backButton: {
    alignItems: 'center',
    marginTop: 10,
  },
  backButtonText: {
    color: '#3D405B',
    textDecorationLine: 'underline',
  },
});
