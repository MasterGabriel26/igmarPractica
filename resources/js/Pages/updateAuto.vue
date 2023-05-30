<template>
    <div class="update-auto-container">
        <h1>Actualizar auto</h1>
        <form @submit="updateAuto" class="update-auto-form">
            <div>
                <label for="id">ID del auto:</label>
                <input type="text" id="id" v-model="id" required>
            </div>
            <div>
                <label for="marca">Marca:</label>
                <input type="text" id="marca" v-model="marca" required>
            </div>
            <div>
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" v-model="modelo" required>
            </div>
            <div>
                <label for="color">Color:</label>
                <input type="text" id="color" v-model="color" required>
            </div>
            <div>
                <label for="year">Año:</label>
                <input type="text" id="year" v-model="year" required>
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" v-model="descripcion" required>
            </div>
            <div>
                <label for="persona_id">ID de la persona:</label>
                <input type="text" id="persona_id" v-model="persona_id" required>
            </div>
            <div>
                <button type="submit">Actualizar Auto</button>
            </div>
        </form>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    props: ['autoSeleccionado'],
    data() {
        return {
            id: '', 
            marca: '',
            modelo: '',
            color: '',
            year: '',
            descripcion: '',
            persona_id: ''
        };
    },
    created() {
        const urlParams = new URLSearchParams(window.location.search);
        this.id = urlParams.get('id'); 
        this.marca = urlParams.get('marca');
        this.modelo = urlParams.get('modelo');
        this.color = urlParams.get('color');
        this.year = urlParams.get('year');
        this.descripcion = urlParams.get('descripcion');
        this.persona_id = urlParams.get('persona_id');
    },
    methods: {
        fetchAuto(id) {
            axios.get(`http://127.0.0.1:8000/api/v1.0/autos/${id}`)
                .then(response => {
                    const auto = response.data.data;
                    this.marca = auto.marca;
                    this.modelo = auto.modelo;
                    this.color = auto.color;
                    this.year = auto.year;
                    this.descripcion = auto.descripcion;
                    this.persona_id = auto.persona_id;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateAuto() {
            axios.put(`http://127.0.0.1:8000/api/v1.0/persona/${this.persona_id}/autos/update/${this.id}`, {
                marca: this.marca,
                modelo: this.modelo,
                color: this.color,
                year: this.year,
                descripcion: this.descripcion,
            })
                .then(response => {
                    console.info(response.data.msg);
                    window.history.back();
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>
  
<style scoped>
.update-auto-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #0d202b3a;
}

.update-auto-form {
  display: flex;
  flex-direction: column;
  width: 30%;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: white;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
  margin-bottom: 1px;
  text-align: center;
  font-weight: bold;
  font-size: 20px;
}

label {
  display: block;
}

input[type="text"] {
  margin-bottom: 10px;
  padding: 5px;
  width: 100%;
}

button[type="submit"] {
  padding: 10px 20px;
  background-color: #0D202B;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: .5s;
  width: 100%;
}
button:hover{
  background-color: #22526e;
}
</style>