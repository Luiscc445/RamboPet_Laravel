import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, TouchableOpacity, StyleSheet, RefreshControl } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { mascotasAPI } from '../../api';

export default function MascotasListScreen({ navigation }) {
  const [mascotas, setMascotas] = useState([]);
  const [refreshing, setRefreshing] = useState(false);

  useEffect(() => {
    loadMascotas();
  }, []);

  const loadMascotas = async () => {
    try {
      const data = await mascotasAPI.getMascotas();
      setMascotas(data);
    } catch (error) {
      console.error('Error cargando mascotas:', error);
    } finally {
      setRefreshing(false);
    }
  };

  const renderMascota = ({ item }) => (
    <View style={styles.card}>
      <View style={styles.avatar}>
        <Text style={styles.emoji}>{item.especie?.nombre === 'Perro' ? '🐕' : '🐈'}</Text>
      </View>
      <View style={styles.info}>
        <Text style={styles.nombre}>{item.nombre}</Text>
        <Text style={styles.detalle}>{item.especie?.nombre} - {item.raza?.nombre || 'Sin raza'}</Text>
        <Text style={styles.detalle}>{item.sexo === 'macho' ? '♂' : '♀'} {item.color}</Text>
      </View>
      <Ionicons name="chevron-forward" size={24} color="#ccc" />
    </View>
  );

  return (
    <View style={styles.container}>
      <FlatList
        data={mascotas}
        renderItem={renderMascota}
        keyExtractor={(item) => item.id.toString()}
        contentContainerStyle={styles.list}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={loadMascotas} />}
        ListEmptyComponent={
          <View style={styles.empty}>
            <Ionicons name="paw-outline" size={64} color="#ccc" />
            <Text style={styles.emptyText}>No tienes mascotas registradas</Text>
          </View>
        }
      />
      <TouchableOpacity
        style={styles.fab}
        onPress={() => navigation.navigate('AddMascota')}
      >
        <Ionicons name="add" size={32} color="white" />
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f5f5f5' },
  list: { padding: 16 },
  card: { flexDirection: 'row', backgroundColor: 'white', padding: 16, borderRadius: 12, marginBottom: 12, alignItems: 'center' },
  avatar: { width: 60, height: 60, borderRadius: 30, backgroundColor: '#f0fdf4', justifyContent: 'center', alignItems: 'center', marginRight: 16 },
  emoji: { fontSize: 32 },
  info: { flex: 1 },
  nombre: { fontSize: 18, fontWeight: 'bold', color: '#333' },
  detalle: { fontSize: 14, color: '#666', marginTop: 4 },
  fab: { position: 'absolute', right: 20, bottom: 20, width: 60, height: 60, borderRadius: 30, backgroundColor: '#10b981', justifyContent: 'center', alignItems: 'center' },
  empty: { alignItems: 'center', marginTop: 100 },
  emptyText: { fontSize: 16, color: '#666', marginTop: 16 },
});
