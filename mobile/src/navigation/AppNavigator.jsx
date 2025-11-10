import React from 'react';
import { ActivityIndicator, View } from 'react-native';
import { createStackNavigator } from '@react-navigation/stack';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { Ionicons } from '@expo/vector-icons';

// Pantallas de autenticación
import LoginScreen from '../screens/Auth/LoginScreen';
import RegisterScreen from '../screens/Auth/RegisterScreen';

// Pantallas principales
import HomeScreen from '../screens/Home/HomeScreen';
import MascotasListScreen from '../screens/Mascotas/MascotasListScreen';
import AddMascotaScreen from '../screens/Mascotas/AddMascotaScreen';
import CitasListScreen from '../screens/Citas/CitasListScreen';
import AgendarCitaScreen from '../screens/Citas/AgendarCitaScreen';
import ProfileScreen from '../screens/Profile/ProfileScreen';

import { useAuth } from '../contexts/AuthContext';

const Stack = createStackNavigator();
const Tab = createBottomTabNavigator();

// Navegación de Tabs Principal
function MainTabs() {
  return (
    <Tab.Navigator
      screenOptions={({ route }) => ({
        tabBarIcon: ({ focused, color, size }) => {
          let iconName;

          if (route.name === 'HomeTab') {
            iconName = focused ? 'home' : 'home-outline';
          } else if (route.name === 'MascotasTab') {
            iconName = focused ? 'paw' : 'paw-outline';
          } else if (route.name === 'CitasTab') {
            iconName = focused ? 'calendar' : 'calendar-outline';
          } else if (route.name === 'ProfileTab') {
            iconName = focused ? 'person' : 'person-outline';
          }

          return <Ionicons name={iconName} size={size} color={color} />;
        },
        tabBarActiveTintColor: '#10b981',
        tabBarInactiveTintColor: 'gray',
        headerShown: false,
      })}
    >
      <Tab.Screen
        name="HomeTab"
        component={HomeScreen}
        options={{ tabBarLabel: 'Inicio' }}
      />
      <Tab.Screen
        name="MascotasTab"
        component={MascotasStack}
        options={{ tabBarLabel: 'Mascotas' }}
      />
      <Tab.Screen
        name="CitasTab"
        component={CitasStack}
        options={{ tabBarLabel: 'Citas' }}
      />
      <Tab.Screen
        name="ProfileTab"
        component={ProfileScreen}
        options={{ tabBarLabel: 'Perfil' }}
      />
    </Tab.Navigator>
  );
}

// Stack de Mascotas
function MascotasStack() {
  return (
    <Stack.Navigator>
      <Stack.Screen
        name="MascotasList"
        component={MascotasListScreen}
        options={{ title: 'Mis Mascotas' }}
      />
      <Stack.Screen
        name="AddMascota"
        component={AddMascotaScreen}
        options={{ title: 'Registrar Mascota' }}
      />
    </Stack.Navigator>
  );
}

// Stack de Citas
function CitasStack() {
  return (
    <Stack.Navigator>
      <Stack.Screen
        name="CitasList"
        component={CitasListScreen}
        options={{ title: 'Mis Citas' }}
      />
      <Stack.Screen
        name="AgendarCita"
        component={AgendarCitaScreen}
        options={{ title: 'Agendar Cita' }}
      />
    </Stack.Navigator>
  );
}

// Stack de Autenticación
function AuthStack() {
  return (
    <Stack.Navigator screenOptions={{ headerShown: false }}>
      <Stack.Screen name="Login" component={LoginScreen} />
      <Stack.Screen name="Register" component={RegisterScreen} />
    </Stack.Navigator>
  );
}

// Navegador Principal
export default function AppNavigator() {
  const { isAuthenticated, loading } = useAuth();

  if (loading) {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <ActivityIndicator size="large" color="#10b981" />
      </View>
    );
  }

  return (
    <Stack.Navigator screenOptions={{ headerShown: false }}>
      {isAuthenticated ? (
        <Stack.Screen name="Main" component={MainTabs} />
      ) : (
        <Stack.Screen name="Auth" component={AuthStack} />
      )}
    </Stack.Navigator>
  );
}
