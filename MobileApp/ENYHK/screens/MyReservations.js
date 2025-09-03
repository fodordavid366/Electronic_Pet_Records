import React, { useEffect, useState } from "react";
import { View, Text, FlatList, TouchableOpacity, StyleSheet, Alert, Modal } from "react-native";
import AsyncStorage from '@react-native-async-storage/async-storage';
import { API_BASE_URL } from '../config';

export default function MyReservations() {
  const [appointments, setAppointments] = useState([]);
  const [selectedNote, setSelectedNote] = useState(null);
  const [modalVisible, setModalVisible] = useState(false);


  async function loadAppointments() {
    try {
        const token = await AsyncStorage.getItem('token');
      const res = await fetch(`${API_BASE_URL}/appointments.php`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      if (!res.ok) throw new Error("Nem sikerült betölteni a foglalásokat");
      const data = await res.json();
      setAppointments(data);
    } catch (err) {
      Alert.alert("Hiba", err.message);
    }
  }

  async function cancelAppointment(id) {
    Alert.alert("Megerősítés", "Biztosan le akarja mondani?", [
      { text: "Mégse" },
      {
        text: "Igen",
        onPress: async () => {
          try {
            const token = await AsyncStorage.getItem('token');
            const res = await fetch(`${API_BASE_URL}/appointments.php`, {
              method: "DELETE",
              headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
              },
              body: JSON.stringify({ appointment_id: id }),
            });
            const data = await res.json();
            Alert.alert("Üzenet", data.message || "Hiba történt");
            loadAppointments();
          } catch (e) {
            Alert.alert("Hiba", "Nem sikerült lemondani");
          }
        },
      },
    ]);
  }

  useEffect(() => {
    loadAppointments();
  }, []);

  const renderItem = ({ item }) => {
    const now = new Date();
    const start = new Date(item.starts_at);
    const diffHours = (start - now) / (1000 * 60 * 60);

    return (
      <View style={styles.card}>
        <Text style={styles.title}>{item.pet_name}</Text>
        <Text>Orvos: {item.vet_name}</Text>
        <Text>Dátum: {item.starts_at.split(" ")[0]}</Text>
        <Text>Időpont: {item.starts_at.split(" ")[1].slice(0, 5)}</Text>
        <Text>Kezelés: {item.treatment_name}</Text>
        <Text>Állapot: {item.status}</Text>

        {item.status === "booked" && diffHours > 1 && (
          <TouchableOpacity
            style={[styles.button, { backgroundColor: "red" }]}
            onPress={() => cancelAppointment(item.appointment_id)}
          >
            <Text style={styles.buttonText}>Lemondás</Text>
          </TouchableOpacity>
        )}

        <TouchableOpacity
          style={styles.noteButton}
          onPress={() => {
            setSelectedNote(item.description || "Nincs jegyzet");
            setModalVisible(true);
          }}
        >
          <Text style={{ color: "#007AFF" }}>Jegyzet megnyitása</Text>
        </TouchableOpacity>
      </View>
    );
  };

  return (
    <View style={styles.container}>
      <Text style={styles.header}>Foglalásaim</Text>
      <FlatList
        data={appointments}
        keyExtractor={(item) => String(item.appointment_id)}
        renderItem={renderItem}
      />

      {/* Modal */}
      <Modal visible={modalVisible} animationType="slide" transparent>
        <View style={styles.modalBg}>
          <View style={styles.modalBox}>
            <Text style={styles.modalTitle}>Állatorvos jegyzete</Text>
            <Text>{selectedNote}</Text>
            <TouchableOpacity
              style={[styles.button, { marginTop: 20 }]}
              onPress={() => setModalVisible(false)}
            >
              <Text style={styles.buttonText}>Bezárás</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, padding: 16, backgroundColor: "#f9f9f9" },
  header: { fontSize: 22, fontWeight: "bold", marginBottom: 16, textAlign: "center" },
  card: {
    backgroundColor: "#fff",
    padding: 16,
    borderRadius: 12,
    marginBottom: 12,
    elevation: 3,
  },
  title: { fontSize: 18, fontWeight: "600", marginBottom: 6 },
  button: {
    marginTop: 10,
    padding: 10,
    borderRadius: 8,
    backgroundColor: "#007AFF",
    alignItems: "center",
  },
  buttonText: { color: "#fff", fontWeight: "600" },
  noteButton: { marginTop: 10 },
  modalBg: {
    flex: 1,
    backgroundColor: "rgba(0,0,0,0.4)",
    justifyContent: "center",
    alignItems: "center",
  },
  modalBox: { backgroundColor: "#fff", padding: 20, borderRadius: 12, width: "80%" },
  modalTitle: { fontSize: 18, fontWeight: "bold", marginBottom: 10 },
});
