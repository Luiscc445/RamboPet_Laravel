import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, ScrollView, Alert } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import * as ImagePicker from 'expo-image-picker';
import { mascotasAPI } from '../../api';

export default function AddMascotaScreen({ navigation }) {
  const [formData, setFormData] = useState({
    nombre: '',
    especie_id: '1',
    fecha_nacimiento: '',
    sexo: 'macho',
    color: '',
    peso: '',
    foto: null,
  });
  const [loading, setLoading] = useState(false);

  const pickImage = async () => {
    const result = await ImagePicker.launchImageLibraryAsync({
      mediaTypes: ImagePicker.MediaTypeOptions.Images,
      allowsEditing: true,
      aspect: [1, 1],
      quality: 0.8,
    });

    if (!result.canceled) {
      setFormData({ ...formData, foto: result.assets[0].uri });
    }
  };

  const handleSubmit = async () => {
    if (!formData.nombre) {
      Alert.alert('Error', 'Ingresa el nombre de tu mascota');
      return;
    }

    try {
      setLoading(true);
      await mascotasAPI.createMascota(formData);
      Alert.alert('Éxito', 'Mascota registrada correctamente', [
        { text: 'OK', onPress: () => navigation.goBack() }
      ]);
    } catch (error) {
      Alert.alert('Error', 'No se pudo registrar la mascota');
    } finally {
      setLoading(false);
    }
  };

  return (
    <ScrollView style={styles.container}>
      <TouchableOpacity style={styles.imageButton} onPress={pickImage}>
        {formData.foto ? (
          <img src={formData.foto} style={styles.image} />
        ) : (
          <View style={styles.placeholder}>
            <Ionicons name="camera" size={40} color="#ccc" />
            <Text style={styles.placeholderText}>Agregar foto</Text>
          </View>
        )}
      </TouchableOpacity>

      <TextInput
        style={styles.input}
        placeholder="Nombre *"
        value={formData.nombre}
        onChangeText={(v) => setFormData({ ...formData, nombre: v })}
      />

      <View style={styles.row}>
        <TouchableOpacity
          style={[styles.option, formData.especie_id === '1' && styles.optionActive]}
          onPress={() => setFormData({ ...formData, especie_id: '1' })}
        >
          <Text style={formData.especie_id === '1' ? styles.optionTextActive : styles.optionText}>🐕 Perro</Text>
        </TouchableOpacity>
        <TouchableOpacity
          style={[styles.option, formData.especie_id === '2' && styles.optionActive]}
          onPress={() => setFormData({ ...formData, especie_id: '2' })}
        >
          <Text style={formData.especie_id === '2' ? styles.optionTextActive : styles.optionText}>🐈 Gato</Text>
        </TouchableOpacity>
      </View>

      <View style={styles.row}>
        <TouchableOpacity
          style={[styles.option, formData.sexo === 'macho' && styles.optionActive]}
          onPress={() => setFormData({ ...formData, sexo: 'macho' })}
        >
          <Text style={formData.sexo === 'macho' ? styles.optionTextActive : styles.optionText}>♂ Macho</Text>
        </TouchableOpacity>
        <TouchableOpacity
          style={[styles.option, formData.sexo === 'hembra' && styles.optionActive]}
          onPress={() => setFormData({ ...formData, sexo: 'hembra' })}
        >
          <Text style={formData.sexo === 'hembra' ? styles.optionTextActive : styles.optionText}>♀ Hembra</Text>
        </TouchableOpacity>
      </View>

      <TextInput
        style={styles.input}
        placeholder="Fecha de nacimiento (YYYY-MM-DD)"
        value={formData.fecha_nacimiento}
        onChangeText={(v) => setFormData({ ...formData, fecha_nacimiento: v })}
      />

      <TextInput
        style={styles.input}
        placeholder="Color"
        value={formData.color}
        onChangeText={(v) => setFormData({ ...formData, color: v })}
      />

      <TextInput
        style={styles.input}
        placeholder="Peso (kg)"
        keyboardType="numeric"
        value={formData.peso}
        onChangeText={(v) => setFormData({ ...formData, peso: v })}
      />

      <TouchableOpacity
        style={styles.button}
        onPress={handleSubmit}
        disabled={loading}
      >
        <Text style={styles.buttonText}>{loading ? 'Guardando...' : 'Registrar Mascota'}</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, padding: 20, backgroundColor: '#f5f5f5' },
  imageButton: { alignSelf: 'center', marginBottom: 20 },
  image: { width: 150, height: 150, borderRadius: 75 },
  placeholder: { width: 150, height: 150, borderRadius: 75, backgroundColor: '#f0f0f0', justifyContent: 'center', alignItems: 'center' },
  placeholderText: { marginTop: 8, color: '#666' },
  input: { backgroundColor: 'white', padding: 16, borderRadius: 12, marginBottom: 16, borderWidth: 1, borderColor: '#e0e0e0' },
  row: { flexDirection: 'row', gap: 12, marginBottom: 16 },
  option: { flex: 1, padding: 16, borderRadius: 12, borderWidth: 2, borderColor: '#e0e0e0', alignItems: 'center' },
  optionActive: { borderColor: '#10b981', backgroundColor: '#f0fdf4' },
  optionText: { color: '#666' },
  optionTextActive: { color: '#10b981', fontWeight: 'bold' },
  button: { backgroundColor: '#10b981', padding: 16, borderRadius: 12, alignItems: 'center', marginTop: 8 },
  buttonText: { color: 'white', fontSize: 18, fontWeight: 'bold' },
});
