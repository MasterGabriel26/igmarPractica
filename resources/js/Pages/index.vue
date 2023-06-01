<template>
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
      <div class="title__container2">
        <DefaultButtonCrud color="primary" size="small" @click="createItem('personas')">Crear Persona</DefaultButtonCrud>
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
    };
  },
  created() {
    this.fetchPersonas();
  },
  methods: {

    fetchPersonas() {
      axios.get('http://127.0.0.1:8000/api/v1.0/personas')
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
        window.location.href = '/updatePerson?id=' + persona.id + '&nombre=' + persona.nombre + '&ap_paterno=' + persona.ap_paterno + '&ap_materno=' + persona.ap_materno;
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

<style>
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
  justify-content: space-between;
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
  height: 100vh;
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
  background-color: #9BBAA9;
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
</style>