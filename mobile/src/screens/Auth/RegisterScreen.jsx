import React, { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  Alert,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
} from 'react-native';
import { useAuth } from '../../contexts/AuthContext';

export default function RegisterScreen({ navigation }) {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    telefono: '',
    rut: '',
    direccion: '',
    password: '',
    password_confirmation: '',
  });
  const [loading, setLoading] = useState(false);
  const { register } = useAuth();

  const handleChange = (field, value) => {
    setFormData({ ...formData, [field]: value });
  };

  const handleRegister = async () => {
    // Validaciones básicas
    if (!formData.name || !formData.email || !formData.password) {
      Alert.alert('Error', 'Por favor completa los campos obligatorios');
      return;
    }

    if (formData.password !== formData.password_confirmation) {
      Alert.alert('Error', 'Las contraseñas no coinciden');
      return;
    }

    if (formData.password.length < 6) {
      Alert.alert('Error', 'La contraseña debe tener al menos 6 caracteres');
      return;
    }

    try {
      setLoading(true);
      await register(formData);

      Alert.alert(
        'Registro exitoso',
        'Tu cuenta ha sido creada correctamente'
      );
      // La navegación se manejará automáticamente por el AppNavigator
    } catch (error) {
      console.error('Error de registro:', error);
      Alert.alert(
        'Error al registrarse',
        error.response?.data?.message || 'Verifica los datos ingresados'
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    >
      <ScrollView contentContainerStyle={styles.scrollContent}>
        <View style={styles.formContainer}>
          <Text style={styles.title}>Crear Cuenta</Text>
          <Text style={styles.subtitle}>Regístrate para agendar citas</Text>

          {/* Nombre */}
          <TextInput
            style={styles.input}
            placeholder="Nombre completo *"
            placeholderTextColor="#999"
            value={formData.name}
            onChangeText={(value) => handleChange('name', value)}
            editable={!loading}
          />

          {/* Email */}
          <TextInput
            style={styles.input}
            placeholder="Email *"
            placeholderTextColor="#999"
            value={formData.email}
            onChangeText={(value) => handleChange('email', value)}
            keyboardType="email-address"
            autoCapitalize="none"
            autoComplete="email"
            editable={!loading}
          />

          {/* Teléfono */}
          <TextInput
            style={styles.input}
            placeholder="Teléfono (opcional)"
            placeholderTextColor="#999"
            value={formData.telefono}
            onChangeText={(value) => handleChange('telefono', value)}
            keyboardType="phone-pad"
            editable={!loading}
          />

          {/* RUT */}
          <TextInput
            style={styles.input}
            placeholder="RUT (opcional)"
            placeholderTextColor="#999"
            value={formData.rut}
            onChangeText={(value) => handleChange('rut', value)}
            editable={!loading}
          />

          {/* Dirección */}
          <TextInput
            style={styles.input}
            placeholder="Dirección (opcional)"
            placeholderTextColor="#999"
            value={formData.direccion}
            onChangeText={(value) => handleChange('direccion', value)}
            editable={!loading}
          />

          {/* Contraseña */}
          <TextInput
            style={styles.input}
            placeholder="Contraseña *"
            placeholderTextColor="#999"
            value={formData.password}
            onChangeText={(value) => handleChange('password', value)}
            secureTextEntry
            autoCapitalize="none"
            editable={!loading}
          />

          {/* Confirmar Contraseña */}
          <TextInput
            style={styles.input}
            placeholder="Confirmar contraseña *"
            placeholderTextColor="#999"
            value={formData.password_confirmation}
            onChangeText={(value) => handleChange('password_confirmation', value)}
            secureTextEntry
            autoCapitalize="none"
            editable={!loading}
          />

          <TouchableOpacity
            style={[styles.button, loading && styles.buttonDisabled]}
            onPress={handleRegister}
            disabled={loading}
          >
            <Text style={styles.buttonText}>
              {loading ? 'Registrando...' : 'Registrarse'}
            </Text>
          </TouchableOpacity>

          <TouchableOpacity
            onPress={() => navigation.goBack()}
            disabled={loading}
            style={styles.backButton}
          >
            <Text style={styles.linkText}>
              ¿Ya tienes cuenta? <Text style={styles.linkBold}>Inicia sesión</Text>
            </Text>
          </TouchableOpacity>
        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  scrollContent: {
    flexGrow: 1,
    justifyContent: 'center',
    padding: 20,
  },
  formContainer: {
    backgroundColor: 'white',
    borderRadius: 16,
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 4,
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 8,
    textAlign: 'center',
  },
  subtitle: {
    fontSize: 16,
    color: '#666',
    marginBottom: 24,
    textAlign: 'center',
  },
  input: {
    backgroundColor: '#f9f9f9',
    padding: 16,
    borderRadius: 12,
    marginBottom: 16,
    borderWidth: 1,
    borderColor: '#e0e0e0',
    fontSize: 16,
  },
  button: {
    backgroundColor: '#10b981',
    padding: 16,
    borderRadius: 12,
    alignItems: 'center',
    marginTop: 8,
  },
  buttonDisabled: {
    backgroundColor: '#9ca3af',
  },
  buttonText: {
    color: 'white',
    fontSize: 18,
    fontWeight: 'bold',
  },
  backButton: {
    marginTop: 16,
  },
  linkText: {
    color: '#666',
    textAlign: 'center',
    fontSize: 16,
  },
  linkBold: {
    color: '#10b981',
    fontWeight: 'bold',
  },
});
