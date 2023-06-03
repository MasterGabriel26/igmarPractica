<template>
  <navigation-link href="/autos" class="nav">Autos</navigation-link>
  <navigation-link @click="createItem('personas')" class="nav2">Crear persona</navigation-link>

  <div class="container">
    <div class="container__tables">
      <div class="title__container">
        <h1>Personas</h1>
        <!-- <DefaultButtonCrud color="primary" size="small" @click="goAutos()">Autos ></DefaultButtonCrud> -->
      </div>
      <div class="container__tables--table">
        <table>
          <thead>
            <tr>
              <th>id</th>
              <th>nombre</th>
              <th>ap_paterno</th>
              <th>ap_materno</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="persona in personas" :key="persona.id">
              <td>{{ persona.id }}</td>
              <td>{{ persona.nombre }}</td>
              <td>{{ persona.ap_paterno }}</td>
              <td>{{ persona.ap_materno }}</td>
              <td>
                <DefaultButtonCrud color="secondary" size="small" @click="editItem('personas', persona)">Editar
                </DefaultButtonCrud>
                <DefaultButtonCrud color="delete" size="small" @click="deleteItem(persona)">
                  Eliminar
                </DefaultButtonCrud>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- <div class="title__container2">
        <DefaultButtonCrud color="primary" size="small" @click="createItem('personas')">Crear Persona</DefaultButtonCrud>
      </div> -->
    </div>
  </div>
</template>

<script>
import DefaultButtonCrud from '../Components/DefaultButtonCrud.vue';
import NavigationLink from '../Components/NavLink.vue';
import axios from 'axios';

export default {
  components: {
    DefaultButtonCrud,
    NavigationLink
  },
  data() {
    return {
      personas: [],
      selectedPersona: null
    };
  },
  created() {
    this.fetchPersonas();
  },
  methods: {

    fetchPersonas() {
      axios.get('/api/v1.0/personas')
        .then(response => {
          this.personas = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    createItem(table) {
      if (table === 'personas') {
        window.location.href = '/createPerson';
      }
    },
    goAutos() {
      window.location.href = '/autos';
    },
    editItem(table, persona) {
      if (table === 'personas' && persona) {
        window.location.href = `/updatePerson/${persona.id}`;
      }
    },

    deleteItem(persona) {
      const deleteUrl = `http://127.0.0.1:8000/api/v1.0/persona/delete/${persona.id}`;

      axios
        .delete(deleteUrl)
        .then(response => {
          if (response.status === 201) {
            const index = this.personas.findIndex(p => p.id === persona.id);
            if (index !== -1) {
              this.personas.splice(index, 1);
              this.updatePersonasTable();
            }
          }
        })
        .catch(error => {
          console.error(error);
        });
    },

    updatePersonasTable() {
      axios.get('http://127.0.0.1:8000/api/v1.0/personas')
        .then(response => {
          this.personas = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
}
</script>
<!-- <template>
  <div class="container">
    <div class="container__tables">
      <div class="title__container">
        <h1>Personas</h1>
        <DefaultButtonCrud color="primary" size="small" @click="goAutos()">Autos ></DefaultButtonCrud>
      </div>
      <div class="container__tables--table">
        <table>
          <thead>
            <tr>
              <th>id</th>
              <th>nombre</th>
              <th>ap_paterno</th>
              <th>ap_materno</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="persona in personas" :key="persona.id">
              <td>{{ persona.id }}</td>
              <td>{{ persona.nombre }}</td>
              <td>{{ persona.ap_paterno }}</td>
              <td>{{ persona.ap_materno }}</td>
              <td>
                <DefaultButtonCrud color="secondary" size="small" @click="openEditModal(persona)">Editar
                </DefaultButtonCrud>
                <DefaultButtonCrud color="delete" size="small" @click="deleteItem(persona)">
                  Eliminar
                </DefaultButtonCrud>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="title__container2">
        <DefaultButtonCrud color="primary" size="small" @click="createItem('personas')">Crear Persona</DefaultButtonCrud>
      </div>
    </div>

    <div class="modal" v-if="editModalOpen">
      <div class="modal__content">
        <h1>Actualizar persona</h1>
        <form @submit.prevent="updatePerson">
          <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" v-model="editPersona.nombre" required>
          </div>
          <div>
            <label for="ap_paterno">Apellido Paterno:</label>
            <input type="text" id="ap_paterno" v-model="editPersona.ap_paterno" required>
          </div>
          <div>
            <label for="ap_materno">Apellido Materno:</label>
            <input type="text" id="ap_materno" v-model="editPersona.ap_materno" required>
          </div>
          <div>
            <label for="id">ID:</label>
            <input type="text" id="id" v-model="editPersona.id" readonly>
          </div>
          <div>
            <button type="submit">Actualizar Persona</button>
          </div>
        </form>
        <button class="modal__close-button" @click="closeEditModal">Cerrar</button>
      </div>
    </div>
  </div>
</template>

<script>
import DefaultButtonCrud from '../Components/DefaultButtonCrud.vue';
import axios from 'axios';

export default {
  components: {
    DefaultButtonCrud
  },
  data() {
    return {
      personas: [],
      editModalOpen: false,
      editPersona: {
        id: '',
        nombre: '',
        ap_paterno: '',
        ap_materno: ''
      }
    };
  },
  created() {
    this.fetchPersonas();
  },
  methods: {
    fetchPersonas() {
      axios.get('/api/v1.0/personas')
        .then(response => {
          this.personas = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    createItem(table) {
      if (table === 'personas') {
        window.location.href = '/createPerson';
      }
    },
    goAutos() {
      window.location.href = '/autos';
    },
    openEditModal(persona) {
      this.editPersona = {
        id: persona.id,
        nombre: persona.nombre,
        ap_paterno: persona.ap_paterno,
        ap_materno: persona.ap_materno
      };
      this.editModalOpen = true;
    },
    closeEditModal() {
      this.editModalOpen = false;
    },
    updatePerson() {
      if (!this.editPersona.nombre || !this.editPersona.ap_paterno || !this.editPersona.ap_materno) {
        alert('Por favor, complete todos los campos requeridos.');
        return;
      }
      axios.put(`http://127.0.0.1:8000/api/v1.0/persona/update/${this.editPersona.id}`, {
          nombre: this.editPersona.nombre,
          ap_paterno: this.editPersona.ap_paterno,
          ap_materno: this.editPersona.ap_materno,
          id: this.editPersona.id
        })
        .then(response => {
          console.info(response.data.msg);
          this.closeEditModal();
          this.fetchPersonas();
        })
        .catch(error => {
          console.error(error);
        });
    },
    deleteItem(persona) {
      const deleteUrl = `http://127.0.0.1:8000/api/v1.0/persona/delete/${persona.id}`;

      axios
        .delete(deleteUrl)
        .then(response => {
          if (response.status === 201) {
            const index = this.personas.findIndex(p => p.id === persona.id);
            if (index !== -1) {
              this.personas.splice(index, 1);
              this.updatePersonasTable();
            }
          }
        })
        .catch(error => {
          console.error(error);
        });
    },
    updatePersonasTable() {
      axios.get('http://127.0.0.1:8000/api/v1.0/personas')
        .then(response => {
          this.personas = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
}
</script> -->
<style>

.nav {
  background-color: #ffffff;
  color: black;
  width: 50%;
  align-items: center;
  text-align: center;
  padding: 1vh;
  transition: .4s;
  border-radius: 0px 0px 0px 10px;
  box-shadow: -5px 0px 8px rgba(0, 0, 0, 0.24);
}
.nav2{
  background-color: #ffffff;
  color: black;
  width: 50%;
  align-items: center;
  text-align: right;
  padding: 1vh 0vh;
  transition: .4s;
  border-radius: 0px 0px 10px 0px;
  box-shadow: 5px 0px 8px rgba(0, 0, 0, 0.24);
}
.nav:hover {
  background-color: #1e212c;
  color: rgb(255, 255, 255);
  width: 50%;
  align-items: center;
  text-align: center;
  padding: 1vh 0vh 2vh 1vh;
  border-radius: 0px 0px 10px 10px;
  box-shadow: -5px 0px 8px rgba(0, 0, 0, 0.24);
}
.nav2:hover {
  background-color: #1e212c;
  color: rgb(255, 255, 255);
  width: 50%;
  align-items: center;
  text-align: right;
  padding: 1vh 0vh 2vh 1vh;
  border-radius: 0px 0px 10px 10px;
  box-shadow: 5px 0px 8px rgba(0, 0, 0, 0.24);
}

body {
  padding: 0;
  margin: 0;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #0d202b3a;
}

.title__container {
  text-align: center;
  align-items: center;
  color: white;
  width: 100%;
  display: flex;
  margin-bottom: 1vh;
  justify-content: center;
}

.title__container2 {
  text-align: center;
  align-items: center;
  color: white;
  width: 100%;
  display: flex;
  justify-content: right;
}

h1 {
  font-size: 20px;
  color: black;
  font-weight: bold;
}

.container {
  width: 100%;
  height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container__tables {
  width: 100%;
  margin: 0 2vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: 100%;
}

.container__tables--table {
  margin: 0 0 2vh;
  height: 45vh;
  width: 100%;
  overflow-y: auto;
  border-radius: 10px;
  background-color: white;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

table {
  width: 100%;
  max-height: 40vh;
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
  padding: 1vh 2vh;
}

tbody tr:hover {
  background-color: #adb3af;
  color: white;
  cursor: pointer;
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

.modal {
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  text-align: center;
  border: 1px solid #888;
  width: 20%;
}

.modal-actions {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.btn-primary {
  background-color: #0D202B;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 10px;
  transition: .5s;
}

.btn-primary:hover {
  background-color: #0D202Bcc;
}

.btn-secondary {
  background-color: #5C6B73;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-secondary:hover {
  background-color: #5C6B73cc;
}

.btn-delete {
  background-color: #FF5858;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 10px;
}

.btn-delete:hover {
  background-color: #FF5858cc;
}

.btn-small {
  padding: 5px 10px;
  font-size: 12px;
}

h2 {
  font-weight: bold;
  text-align: start;
  margin-bottom: 3vh;
}

p {
  text-align: start;
}

.btn-delete-small {
  background-color: #FF5858;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 5px;
}

.btn-delete-small:hover {
  background-color: #FF5858cc;
}

@media (max-width: 768px) {
  table {
    width: auto;
    /* Cambia el ancho de la tabla a automático para que se ajuste al contenido */
  }

  th,
  td {
    white-space: nowrap;
    /* Evita el ajuste de línea en celdas de la tabla */
  }
}

@media (max-width: 600px) {
  .container {
    display: flex;
    justify-content: center;
    ;
    width: 100%;
  }

  .container__tables--table {
    width: 100%;
    max-height: 40vh;
  }

  .table-wrapper {
    overflow-x: auto;
  }

  table {
    width: auto;
    max-height: 40vh;
    /* Cambia el ancho de la tabla a automático para que se ajuste al contenido */
  }

  tr {
    display: flex;
    flex-direction: column;
  }

  tr th {
    display: none;
  }

  th,
  td {
    white-space: nowrap;
    /* Evita el ajuste de línea en celdas de la tabla */
  }
}
</style>