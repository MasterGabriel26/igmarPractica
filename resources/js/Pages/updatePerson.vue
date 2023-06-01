<template>
    <div class="update-auto-container">
        <h1>Actualizar persona</h1>
        <form @submit="updatePerson" class="update-auto-form">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" v-model="nombre" required>
            </div>
            <div>
                <label for="ap_paterno">Apellido Paterno:</label>
                <input type="text" id="ap_paterno" v-model="ap_paterno" required>
            </div>
            <div>
                <label for="ap_materno">Apellido Materno:</label>
                <input type="text" id="ap_materno" v-model="ap_materno" required>
            </div>
            <div>
                <label for="color">ID:</label>
                <input type="text" id="color" v-model="id" readonly>
            </div>
            <div>
                <button type="submit">Actualizar Persona</button>
            </div>
        </form>
    </div>
</template>
  
<script>
import axios from 'axios';
export default {
    props: ['personaSeleccionada'],
    data() {
        return {
            nombre: '',
            ap_paterno: '',
            ap_materno: '',
            id: ''
        };
    },
    created() {
        const urlParams = new URLSearchParams(window.location.search);
        this.id = urlParams.get('id');
        this.nombre = urlParams.get('nombre');
        this.ap_paterno = urlParams.get('ap_paterno');
        this.ap_materno = urlParams.get('ap_materno');
    },
    methods: {
        fetchPerson(id) {
            axios.get(`http://127.0.0.1:8000/api/v1.0/personas/${id}`)
                .then(response => {
                    const persona = response.data.data;
                    this.nombre = persona.nombre;
                    this.ap_paterno = persona.ap_paterno;
                    this.ap_materno = persona.ap_materno;
                    this.id = persona.id;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updatePerson() {
            axios.put(`http://127.0.0.1:8000/api/v1.0/persona/update/${this.id}`, {
                nombre: this.nombre,
                ap_paterno: this.ap_paterno,
                ap_materno: this.ap_materno,
                id: this.id
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