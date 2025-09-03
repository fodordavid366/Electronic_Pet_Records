// screens/MainTabs.js
import React from 'react';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import HomeScreen from './HomeScreen';
import MyPetsScreen from './MyPetsScreen';
import MyReservations from './MyReservations';
import ProfileScreen from './ProfileScreen';
import { Ionicons } from '@expo/vector-icons';
import ReservationScreen from './ReservationScreen';

const Tab = createBottomTabNavigator();

export default function MainTabs() {
  return (
    <Tab.Navigator screenOptions={{ headerShown: false }}>
        <Tab.Screen 
        name="Foglalás" 
        component={ReservationScreen} 
        options={{ tabBarIcon: ({ color, size }) => <Ionicons name="alarm-outline" size={size} color={color} /> }}
      />
      <Tab.Screen 
        name="Kedvencek" 
        component={MyPetsScreen} 
        options={{ tabBarIcon: ({ color, size }) => <Ionicons name="paw" size={size} color={color} /> }}
      />
      <Tab.Screen 
        name="Időpontjaim" 
        component={MyReservations} 
        options={{ tabBarIcon: ({ color, size }) => <Ionicons name="calendar" size={size} color={color} /> }}
      />
      <Tab.Screen 
        name="Profil" 
        component={ProfileScreen} 
        options={{ tabBarIcon: ({ color, size }) => <Ionicons name="person" size={size} color={color} /> }}
      />
    </Tab.Navigator>
  );
}
