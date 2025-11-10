import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  ScrollView,
  StyleSheet,
  TouchableOpacity,
  RefreshControl,
  Alert,
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { mascotasAPI, citasAPI, authAPI } from '../../api';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';
import { ESTADOS_CITA } from '../../utils/constants';

export default function HomeScreen({ navigation }) {
  const [user, setUser] = useState(null);
  const [mascotas, setMascotas] = useState([]);
  const [citas, setCitas] = useState([]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    try {
      const [userData, mascotasData, citasData] = await Promise.all([
        authAPI.getMe(),
        mascotasAPI.getMascotas(),
        citasAPI.getCitas(),
      ]);

      setUser(userData);
      setMascotas(mascotasData);
      setCitas(citasData);
    } catch (error) {
      console.error('Error cargando datos:', error);
      Alert.alert('Error', 'No se pudieron cargar los datos');
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const onRefresh = () => {
    setRefreshing(true);
    loadData();
  };

  const getProximasCitas = () => {
    const now = new Date();
    return citas
      .filter((cita) => {
        const fechaCita = new Date(cita.fecha_hora);
        return fechaCita > now && cita.estado !== 'cancelada';
      })
      .sort((a, b) => new Date(a.fecha_hora) - new Date(b.fecha_hora))
      .slice(0, 3);
  };

  const proximasCitas = getProximasCitas();

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <Text>Cargando...</Text>
      </View>
    );
  }

  return (
    <ScrollView
      style={styles.container}
      refreshControl={
        <RefreshControl refreshing={refreshing} onRefresh={onRefresh} />
      }
    >
      {/* Header */}
      <View style={styles.header}>
        <View>
          <Text style={styles.greeting}>Hola, {user?.name} 👋</Text>
          <Text style={styles.subtitle}>Bienvenido a RamboPet</Text>
        </View>
        <TouchableOpacity
          style={styles.notificationButton}
          onPress={() => navigation.navigate('ProfileTab')}
        >
          <Ionicons name="person-circle-outline" size={32} color="#10b981" />
        </TouchableOpacity>
      </View>

      {/* Estadísticas */}
      <View style={styles.statsContainer}>
        <View style={styles.statCard}>
          <Ionicons name="paw" size={32} color="#10b981" />
          <Text style={styles.statNumber}>{mascotas.length}</Text>
          <Text style={styles.statLabel}>Mascotas</Text>
        </View>

        <View style={styles.statCard}>
          <Ionicons name="calendar" size={32} color="#3b82f6" />
          <Text style={styles.statNumber}>{proximasCitas.length}</Text>
          <Text style={styles.statLabel}>Citas Próximas</Text>
        </View>

        <View style={styles.statCard}>
          <Ionicons name="checkmark-circle" size={32} color="#10b981" />
          <Text style={styles.statNumber}>
            {citas.filter((c) => c.estado === 'completada').length}
          </Text>
          <Text style={styles.statLabel}>Completadas</Text>
        </View>
      </View>

      {/* Acciones Rápidas */}
      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Acciones Rápidas</Text>
        <View style={styles.actionsContainer}>
          <TouchableOpacity
            style={styles.actionButton}
            onPress={() => navigation.navigate('MascotasTab', { screen: 'AddMascota' })}
          >
            <Ionicons name="add-circle" size={24} color="white" />
            <Text style={styles.actionText}>Registrar Mascota</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={[styles.actionButton, styles.actionButtonSecondary]}
            onPress={() => navigation.navigate('CitasTab', { screen: 'AgendarCita' })}
          >
            <Ionicons name="calendar-outline" size={24} color="white" />
            <Text style={styles.actionText}>Agendar Cita</Text>
          </TouchableOpacity>
        </View>
      </View>

      {/* Próximas Citas */}
      <View style={styles.section}>
        <View style={styles.sectionHeader}>
          <Text style={styles.sectionTitle}>Próximas Citas</Text>
          <TouchableOpacity onPress={() => navigation.navigate('CitasTab')}>
            <Text style={styles.seeAllText}>Ver todas</Text>
          </TouchableOpacity>
        </View>

        {proximasCitas.length === 0 ? (
          <View style={styles.emptyState}>
            <Ionicons name="calendar-outline" size={48} color="#ccc" />
            <Text style={styles.emptyText}>No tienes citas próximas</Text>
            <TouchableOpacity
              style={styles.emptyButton}
              onPress={() => navigation.navigate('CitasTab', { screen: 'AgendarCita' })}
            >
              <Text style={styles.emptyButtonText}>Agendar una cita</Text>
            </TouchableOpacity>
          </View>
        ) : (
          proximasCitas.map((cita) => (
            <View key={cita.id} style={styles.citaCard}>
              <View style={styles.citaHeader}>
                <Text style={styles.citaMascota}>{cita.mascota?.nombre}</Text>
                <View
                  style={[
                    styles.estadoBadge,
                    { backgroundColor: ESTADOS_CITA[cita.estado]?.color },
                  ]}
                >
                  <Text style={styles.estadoText}>
                    {ESTADOS_CITA[cita.estado]?.label}
                  </Text>
                </View>
              </View>
              <Text style={styles.citaVeterinario}>
                Dr(a). {cita.veterinario?.name}
              </Text>
              <Text style={styles.citaFecha}>
                {format(new Date(cita.fecha_hora), "d 'de' MMMM, HH:mm", {
                  locale: es,
                })}
              </Text>
            </View>
          ))
        )}
      </View>

      {/* Mis Mascotas */}
      <View style={styles.section}>
        <View style={styles.sectionHeader}>
          <Text style={styles.sectionTitle}>Mis Mascotas</Text>
          <TouchableOpacity onPress={() => navigation.navigate('MascotasTab')}>
            <Text style={styles.seeAllText}>Ver todas</Text>
          </TouchableOpacity>
        </View>

        {mascotas.length === 0 ? (
          <View style={styles.emptyState}>
            <Ionicons name="paw-outline" size={48} color="#ccc" />
            <Text style={styles.emptyText}>No tienes mascotas registradas</Text>
            <TouchableOpacity
              style={styles.emptyButton}
              onPress={() => navigation.navigate('MascotasTab', { screen: 'AddMascota' })}
            >
              <Text style={styles.emptyButtonText}>Registrar mascota</Text>
            </TouchableOpacity>
          </View>
        ) : (
          <ScrollView horizontal showsHorizontalScrollIndicator={false}>
            {mascotas.slice(0, 5).map((mascota) => (
              <View key={mascota.id} style={styles.mascotaCard}>
                <View style={styles.mascotaAvatar}>
                  <Text style={styles.mascotaEmoji}>
                    {mascota.especie?.nombre === 'Perro' ? '🐕' : '🐈'}
                  </Text>
                </View>
                <Text style={styles.mascotaNombre}>{mascota.nombre}</Text>
                <Text style={styles.mascotaEspecie}>{mascota.especie?.nombre}</Text>
              </View>
            ))}
          </ScrollView>
        )}
      </View>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: 20,
    paddingTop: 60,
    backgroundColor: 'white',
  },
  greeting: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
  },
  subtitle: {
    fontSize: 14,
    color: '#666',
    marginTop: 4,
  },
  notificationButton: {
    padding: 8,
  },
  statsContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    padding: 20,
    paddingTop: 16,
  },
  statCard: {
    flex: 1,
    backgroundColor: 'white',
    borderRadius: 16,
    padding: 16,
    marginHorizontal: 4,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
  },
  statNumber: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    marginTop: 8,
  },
  statLabel: {
    fontSize: 12,
    color: '#666',
    marginTop: 4,
  },
  section: {
    padding: 20,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 16,
  },
  sectionTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#333',
  },
  seeAllText: {
    fontSize: 14,
    color: '#10b981',
    fontWeight: '600',
  },
  actionsContainer: {
    flexDirection: 'row',
    gap: 12,
  },
  actionButton: {
    flex: 1,
    backgroundColor: '#10b981',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    padding: 16,
    borderRadius: 12,
    gap: 8,
  },
  actionButtonSecondary: {
    backgroundColor: '#3b82f6',
  },
  actionText: {
    color: 'white',
    fontWeight: 'bold',
    fontSize: 14,
  },
  citaCard: {
    backgroundColor: 'white',
    borderRadius: 12,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.1,
    shadowRadius: 2,
    elevation: 2,
  },
  citaHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 8,
  },
  citaMascota: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#333',
  },
  citaVeterinario: {
    fontSize: 14,
    color: '#666',
    marginBottom: 4,
  },
  citaFecha: {
    fontSize: 14,
    color: '#10b981',
    fontWeight: '600',
  },
  estadoBadge: {
    paddingHorizontal: 12,
    paddingVertical: 4,
    borderRadius: 12,
  },
  estadoText: {
    color: 'white',
    fontSize: 12,
    fontWeight: 'bold',
  },
  mascotaCard: {
    backgroundColor: 'white',
    borderRadius: 12,
    padding: 16,
    marginRight: 12,
    alignItems: 'center',
    width: 120,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.1,
    shadowRadius: 2,
    elevation: 2,
  },
  mascotaAvatar: {
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: '#f0fdf4',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 8,
  },
  mascotaEmoji: {
    fontSize: 32,
  },
  mascotaNombre: {
    fontSize: 14,
    fontWeight: 'bold',
    color: '#333',
    textAlign: 'center',
  },
  mascotaEspecie: {
    fontSize: 12,
    color: '#666',
    marginTop: 4,
  },
  emptyState: {
    backgroundColor: 'white',
    borderRadius: 12,
    padding: 32,
    alignItems: 'center',
  },
  emptyText: {
    fontSize: 16,
    color: '#666',
    marginTop: 16,
    marginBottom: 16,
  },
  emptyButton: {
    backgroundColor: '#10b981',
    paddingHorizontal: 24,
    paddingVertical: 12,
    borderRadius: 8,
  },
  emptyButtonText: {
    color: 'white',
    fontWeight: 'bold',
  },
});
