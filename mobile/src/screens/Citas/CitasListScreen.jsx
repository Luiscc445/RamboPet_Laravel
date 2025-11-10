import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, TouchableOpacity, StyleSheet, RefreshControl, Alert } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { citasAPI } from '../../api';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';
import { ESTADOS_CITA, TIPOS_CONSULTA } from '../../utils/constants';

export default function CitasListScreen({ navigation }) {
  const [citas, setCitas] = useState([]);
  const [refreshing, setRefreshing] = useState(false);

  useEffect(() => {
    loadCitas();
  }, []);

  const loadCitas = async () => {
    try {
      const data = await citasAPI.getCitas();
      setCitas(data);
    } catch (error) {
      console.error('Error cargando citas:', error);
    } finally {
      setRefreshing(false);
    }
  };

  const handleCancel = async (id) => {
    Alert.alert(
      'Cancelar Cita',
      '¿Estás seguro de cancelar esta cita?',
      [
        { text: 'No', style: 'cancel' },
        {
          text: 'Sí, cancelar',
          style: 'destructive',
          onPress: async () => {
            try {
              await citasAPI.cancelCita(id);
              loadCitas();
              Alert.alert('Éxito', 'Cita cancelada correctamente');
            } catch (error) {
              Alert.alert('Error', 'No se pudo cancelar la cita');
            }
          },
        },
      ]
    );
  };

  const renderCita = ({ item }) => (
    <View style={styles.card}>
      <View style={styles.header}>
        <Text style={styles.mascota}>{item.mascota?.nombre}</Text>
        <View style={[styles.badge, { backgroundColor: ESTADOS_CITA[item.estado]?.color }]}>
          <Text style={styles.badgeText}>{ESTADOS_CITA[item.estado]?.label}</Text>
        </View>
      </View>
      <Text style={styles.veterinario}>Dr(a). {item.veterinario?.name}</Text>
      <Text style={styles.tipo}>{TIPOS_CONSULTA[item.tipo_consulta]}</Text>
      <Text style={styles.fecha}>
        {format(new Date(item.fecha_hora), "d 'de' MMMM, HH:mm", { locale: es })}
      </Text>
      {item.estado === 'pendiente' && (
        <TouchableOpacity
          style={styles.cancelButton}
          onPress={() => handleCancel(item.id)}
        >
          <Text style={styles.cancelText}>Cancelar cita</Text>
        </TouchableOpacity>
      )}
    </View>
  );

  return (
    <View style={styles.container}>
      <FlatList
        data={citas}
        renderItem={renderCita}
        keyExtractor={(item) => item.id.toString()}
        contentContainerStyle={styles.list}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={loadCitas} />}
        ListEmptyComponent={
          <View style={styles.empty}>
            <Ionicons name="calendar-outline" size={64} color="#ccc" />
            <Text style={styles.emptyText}>No tienes citas agendadas</Text>
          </View>
        }
      />
      <TouchableOpacity style={styles.fab} onPress={() => navigation.navigate('AgendarCita')}>
        <Ionicons name="add" size={32} color="white" />
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f5f5f5' },
  list: { padding: 16 },
  card: { backgroundColor: 'white', padding: 16, borderRadius: 12, marginBottom: 12 },
  header: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginBottom: 8 },
  mascota: { fontSize: 18, fontWeight: 'bold', color: '#333' },
  badge: { paddingHorizontal: 12, paddingVertical: 4, borderRadius: 12 },
  badgeText: { color: 'white', fontSize: 12, fontWeight: 'bold' },
  veterinario: { fontSize: 14, color: '#666', marginBottom: 4 },
  tipo: { fontSize: 14, color: '#666', marginBottom: 4 },
  fecha: { fontSize: 14, color: '#10b981', fontWeight: '600' },
  cancelButton: { marginTop: 12, padding: 12, backgroundColor: '#fee2e2', borderRadius: 8 },
  cancelText: { color: '#dc2626', textAlign: 'center', fontWeight: 'bold' },
  fab: { position: 'absolute', right: 20, bottom: 20, width: 60, height: 60, borderRadius: 30, backgroundColor: '#10b981', justifyContent: 'center', alignItems: 'center' },
  empty: { alignItems: 'center', marginTop: 100 },
  emptyText: { fontSize: 16, color: '#666', marginTop: 16 },
});
