<template>
    <div class="update-auto-container">
        <form @submit="updateAuto" class="update-auto-form">
            <h1>Actualizar auto</h1>
            <div>
                <label for="id">ID del auto:</label>
                <input type="text" id="id" v-model="id" readonly>
            </div>
            <div>
                <label for="marca">Marca:</label>
                <input type="text" id="marca" v-model="marca" required>
            </div>
            <div>
                <label for="modelo">Modelo:</label>
                <select v-model="modelo" required>
                    <option value="">Seleccione un modelo</option>
                    <option v-for="modelo in modelos" :key="modelo.id" :value="modelo.nombre_modelo">
                        {{ modelo.nombre_modelo }}
                    </option>
                </select>
            </div>
            <div>
                <label for="color">Color:</label>
                <input type="text" id="color" v-model="color" required>
            </div>
            <div>
                <label for="persona_id">ID de la persona:</label>
                <select v-model="persona_id" required>
                    <option value="">Seleccione una persona</option>
                    <option v-for="persona in personas" :key="persona.id" :value="persona.id">
                        {{ persona.id + '&nbsp;&nbsp;&nbsp;' + persona.nombre }}
                    </option>
                </select>
            </div>
            <div>
                <button type="submit">Actualizar Auto</button>
            </div>
        </form>
        <div class="tableContainer">
            <div class="title__container">
                <h2>Modelos</h2>
            </div>
            <div class="container__tables--table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Modelo</th>
                            <th>Descripcion</th>
                            <th>Año</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="modelo in modelos" :key="modelo.id">
                            <td>{{ modelo.id }}</td>
                            <td>{{ modelo.nombre_modelo }}</td>
                            <td class="descripcion-column">{{ modelo.descripcion }}</td>
                            <td>{{ modelo.year }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    data() {
        return {
            personas: [],
            modelos: [],
            id: '',
            marca: '',
            modelo: '',
            color: '',
            persona_id: '',
        };
    },
    created() {
        // const urlParams = new URLSearchParams(window.location.search);
        // this.id = urlParams.get('id'); 
        // this.marca = urlParams.get('marca');
        // this.modelo = urlParams.get('modelo');
        // this.color = urlParams.get('color');
        // this.year = urlParams.get('year');
        // this.descripcion = urlParams.get('descripcion');
        // this.persona_id = urlParams.get('persona_id');
        const id = window.location.pathname.split('/').pop();
        this.id = id;
        this.fetchAuto(id);
        this.fetchModelos();
        this.fetchPersonas();
    },
    methods: {
        fetchModelos() {
            axios.get('/api/v1.0/catalogo')
                .then(response => {
                    this.modelos = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchPersonas() {
            axios.get('/api/v1.0/personas') 
                .then(response => {
                    this.personas = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchAuto(id) {
            axios.get(`/api/v1.0/auto/${id}`)
                .then(response => {
                    console.log(response.data)
                    const auto = response.data.data;
                    this.marca = auto.marca;
                    this.modelo = auto.modelo;
                    this.color = auto.color;
                    this.persona_id = auto.persona_id;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateAuto() {
            // Verificar campos requeridos
            if (!this.marca || !this.modelo || !this.color || !this.persona_id) {
                alert('Por favor, complete todos los campos requeridos.');
                return;
            }
            axios.put(`/api/v1.0/persona/${this.persona_id}/autos/update/${this.id}`, {
                marca: this.marca,
                modelo: this.modelo,
                color: this.color,
                persona_id: this.persona_id
            })
                .then(response => {
                    console.log(response);
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
.navContainer {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 1vh;
}

.nav {
    background-color: #0D202B;
    border-radius: 3px;
    align-items: center;
    text-align: center;
    transition: .4s;
    align-content: center;
    color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.21);
}

.nav:hover {
    background-color: #0D202B;
    border-radius: 3px;
    align-items: center;
    text-align: center;
    transform: rotate(10deg);
    align-content: center;
    color: rgb(255, 255, 255);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.21);
}

.update-auto-container {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    align-items: center;
    justify-content: space-evenly;
    height: 100vh;
    background-color: #0d202b3a;
}

.update-auto-form {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    width: 25%;
    padding: 1rem 8px;
    margin: 0vh 5vh;
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
    width: 100%;
}

input[type="text"] {
    margin-bottom: 10px;
    padding: 5px;
    width: 100%;
}

select {
    margin-bottom: 1vh;
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

button:hover {
    background-color: #22526e;
}

.title__container {
    text-align: center;
    color: white;
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 1vh;
}

h2 {
    width: 100%;
    font-size: 20px;
    border-radius: 10px 10px 1px 0px;
    color: black;
    font-size: 20px;
    font-weight: bold;
}

.container__tables--table {
    margin: 0 0 2vh;
    height: 56vh;
    width: 100%;
    overflow-y: auto;
    border-radius: 5px;
    background-color: white;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    display: flex;
    flex-direction: column;
}

.descripcion-column {
    max-width: 50vh;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 0vh 2vh;
    font-style: italic;
}

.tableContainer {
    width: 50%;
    margin: 0vh 15vh;
}

table {
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}

thead {
    position: sticky;
    top: 0;
    background-color: #1e212c;
    color: white;
}

th {
    padding: 2vh 2vh;
}

tbody tr:hover {
    background-color: #adb3af;
    color: white;
    cursor: pointer;
}

td {
    padding: 2vh 0vh;
}

td:nth-child(2) {
    padding: 2vh 0vh;
    font-weight: bold;
}

td:nth-child(4) {
    padding: 2vh 0vh;
    font-weight: bold;
}

.container__tables--table::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}

.container__tables--table::-webkit-scrollbar-track {
    background-color: #f5f5f5;
    border-radius: 4px;
}

.container__tables--table::-webkit-scrollbar-thumb {
    background-color: #0D202B;
    border-radius: 4px;
}

.container__tables--table::-webkit-scrollbar-thumb:hover {
    background-color: #555;
}
</style>