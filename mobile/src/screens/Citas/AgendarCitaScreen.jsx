import React, { useState, useEffect } from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView, Alert } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import { mascotasAPI, citasAPI } from '../../api';
import { TIPOS_CONSULTA } from '../../utils/constants';

export default function AgendarCitaScreen({ navigation }) {
  const [mascotas, setMascotas] = useState([]);
  const [veterinarios, setVeterinarios] = useState([]);
  const [formData, setFormData] = useState({
    mascota_id: '',
    veterinario_id: '',
    fecha_hora: '',
    tipo_consulta: 'consulta_general',
    motivo: '',
  });
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    const [mascotasData, veterinariosData] = await Promise.all([
      mascotasAPI.getMascotas(),
      citasAPI.getVeterinarios(),
    ]);
    setMascotas(mascotasData);
    setVeterinarios(veterinariosData);
  };

  const handleSubmit = async () => {
    if (!formData.mascota_id || !formData.veterinario_id || !formData.fecha_hora) {
      Alert.alert('Error', 'Completa todos los campos requeridos');
      return;
    }

    try {
      setLoading(true);
      await citasAPI.createCita(formData);
      Alert.alert('Éxito', '¡Cita agendada correctamente!', [
        { text: 'OK', onPress: () => navigation.goBack() }
      ]);
    } catch (error) {
      Alert.alert('Error', 'No se pudo agendar la cita');
    } finally {
      setLoading(false);
    }
  };

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>Agendar Nueva Cita</Text>

      <Text style={styles.label}>Mascota *</Text>
      <Picker
        selectedValue={formData.mascota_id}
        onValueChange={(v) => setFormData({ ...formData, mascota_id: v })}
        style={styles.picker}
      >
        <Picker.Item label="Selecciona una mascota" value="" />
        {mascotas.map((m) => (
          <Picker.Item key={m.id} label={m.nombre} value={m.id.toString()} />
        ))}
      </Picker>

      <Text style={styles.label}>Veterinario *</Text>
      <Picker
        selectedValue={formData.veterinario_id}
        onValueChange={(v) => setFormData({ ...formData, veterinario_id: v })}
        style={styles.picker}
      >
        <Picker.Item label="Selecciona un veterinario" value="" />
        {veterinarios.map((v) => (
          <Picker.Item key={v.id} label={v.name} value={v.id.toString()} />
        ))}
      </Picker>

      <Text style={styles.label}>Tipo de Consulta *</Text>
      <Picker
        selectedValue={formData.tipo_consulta}
        onValueChange={(v) => setFormData({ ...formData, tipo_consulta: v })}
        style={styles.picker}
      >
        {Object.entries(TIPOS_CONSULTA).map(([key, value]) => (
          <Picker.Item key={key} label={value} value={key} />
        ))}
      </Picker>

      <Text style={styles.info}>
        📅 Fecha: Ingresa en formato YYYY-MM-DD HH:MM
        {'\n'}Ejemplo: 2025-11-15 14:30
      </Text>

      <TouchableOpacity
        style={styles.button}
        onPress={handleSubmit}
        disabled={loading}
      >
        <Text style={styles.buttonText}>{loading ? 'Agendando...' : 'Agendar Cita'}</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, padding: 20, backgroundColor: '#f5f5f5' },
  title: { fontSize: 24, fontWeight: 'bold', marginBottom: 20, color: '#333' },
  label: { fontSize: 16, fontWeight: '600', marginBottom: 8, color: '#333' },
  picker: { backgroundColor: 'white', marginBottom: 16, borderRadius: 12 },
  info: { backgroundColor: '#eff6ff', padding: 16, borderRadius: 12, marginBottom: 16, color: '#1e40af' },
  button: { backgroundColor: '#10b981', padding: 16, borderRadius: 12, alignItems: 'center' },
  buttonText: { color: 'white', fontSize: 18, fontWeight: 'bold' },
});
