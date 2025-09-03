// App.js
import React, { useEffect, useState } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import AsyncStorage from '@react-native-async-storage/async-storage';


import LoginScreen from './screens/LoginScreen';
import RegisterScreen from './screens/RegisterScreen';
import ForgotPasswordScreen from './screens/ForgotPasswordScreen';
import HomeScreen from './screens/HomeScreen';
import ProfileScreen from './screens/ProfileScreen';
import MyPetsScreen from './screens/MyPetsScreen';
import MyReservations from './screens/MyReservations';
import MainTabs from './screens/MainTabs';




const Stack = createNativeStackNavigator();

export default function App() {
  const [initialRoute, setInitialRoute] = useState(null); // null = még nem ellenőriztük

  useEffect(() => {
    const checkToken = async () => {
      const token = await AsyncStorage.getItem('token');
      if (token) {
        setInitialRoute('MainTabs');
      } else {
        setInitialRoute('Login');
      }
    };
    checkToken();
  }, []);

  if (!initialRoute) {
    return null; // vagy egy SplashScreen, amíg töltünk
  }

  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName={initialRoute}>
        <Stack.Screen name="Login" component={LoginScreen} options={{ headerShown: false }} />
        <Stack.Screen name="Register" component={RegisterScreen} options={{ title: "" }}/>
        <Stack.Screen name="ForgotPassword" component={ForgotPasswordScreen} options={{ title: "" }}/>
        <Stack.Screen name="Home" component={HomeScreen} options={{ headerLeft: () => null }} />
        <Stack.Screen name="Profile" component={ProfileScreen} options={{ title: '' }} />
        <Stack.Screen name="MyPets" component={MyPetsScreen} options={{ title: '' }} />
        <Stack.Screen name="MyReservations" component={MyReservations} options={{ title: '' }} />
        
        <Stack.Screen name="MainTabs" component={MainTabs} options={{ title: '' }} />

      </Stack.Navigator>
    </NavigationContainer>
  );
}
