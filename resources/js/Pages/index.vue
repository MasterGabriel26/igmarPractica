<template>
  <div class="container">
    <div class="container__tables">
      <div class="title__container">
        <h1>Modelos</h1>
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
              <td>{{ modelo.descripcion }}</td>
              <td>{{ modelo.year }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="title__container">
        <h1>Personas</h1>
        <DefaultButtonCrud color="primary" size="small" @click="createItem('personas')">Crear</DefaultButtonCrud>
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
                <DefaultButtonCrud color="delete" size="small" @click="showPersonasModal = true; selectedItem = persona">
                  Eliminar
                </DefaultButtonCrud>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="title__container">
        <h1>Autos</h1>
        <DefaultButtonCrud color="primary" size="small" @click="createItem('autos')">Crear</DefaultButtonCrud>
      </div>
      <div class="container__tables--table">
        <table>
          <thead>
            <tr>
              <th>id</th>
              <th>marca</th>
              <th>modelo</th>
              <th>color</th>
              <th>Year</th>
              <th>Descripcion</th>
              <th>persona</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="auto in autos" :key="auto.id">
              <td>{{ auto.id }}</td>
              <td>{{ auto.marca }}</td>
              <td>{{ auto.modelo }}</td>
              <td>{{ auto.color }}</td>
              <td>{{ auto.year }}</td>
              <td>{{ auto.descripcion }}</td>
              <td>{{ auto.persona_id }}</td>
              <td>
                <DefaultButtonCrud color="secondary" size="small" @click="editItem('autos', null, auto)">Editar
                </DefaultButtonCrud>
                <DefaultButtonCrud color="delete" size="small" @click="showAutosModal = true; selectedItem = auto">
                  Eliminar
                </DefaultButtonCrud>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="showPersonasModal" class="modal">
      <div class="modal-content">
        <h2>Confirmar eliminación (Personas)</h2>
        <p>¿Estás seguro de que deseas eliminar esta persona?</p>
        <div class="modal-actions">
          <button class="btn-primary" @click="confirmDelete('personas')">Eliminar</button>
          <button class="btn-primary" @click="closeModal('personas')">Cancelar</button>
        </div>
      </div>
    </div>

    <div v-if="showAutosModal" class="modal">
      <div class="modal-content">
        <h2>Confirmar eliminación (Autos)</h2>
        <p>¿Estás seguro de que deseas eliminar este auto?</p>
        <div class="modal-actions">
          <button class="btn-primary" @click="confirmDelete('autos')">Eliminar</button>
          <button class="btn-primary" @click="closeModal('autos')">Cancelar</button>
        </div>
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
      modelos: [],
      personas: [],
      autos: [],
      showPersonasModal: false,
      showAutosModal: false,
    };
  },
  created() {
    this.fetchModelos();
    this.fetchPersonas();
    this.fetchAutos();
  },
  methods: {
    fetchModelos() {
      axios.get('http://127.0.0.1:8000/api/v1.0/catalogo')
        .then(response => {
          this.modelos = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    fetchPersonas() {
      axios.get('http://127.0.0.1:8000/api/v1.0/personas')
        .then(response => {
          this.personas = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    fetchAutos() {
      axios.get('http://127.0.0.1:8000/api/v1.0/autos')
        .then(response => {
          this.autos = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    createItem(table) {
      if (table === 'personas') {
        window.location.href = '/createPerson';
      }
      if (table === 'autos') {
        window.location.href = '/createAuto';
      }
    },
    editItem(table, persona, auto) {
      if (table === 'personas' && persona) {
        window.location.href = '/updatePerson?id=' + persona.id + '&nombre=' + persona.nombre + '&ap_paterno=' + persona.ap_paterno + '&ap_materno=' + persona.ap_materno;
      }
      if (table === 'autos' && auto) {
        window.location.href = '/updateAuto?id=' + auto.id + '&marca=' + auto.marca + '&modelo=' + auto.modelo + '&color=' + auto.color + '&year=' + auto.year + '&descripcion=' + auto.descripcion + '&persona_id=' + auto.persona_id;
      }
    },
    deleteItem(table) {
      if (table === 'personas') {
        this.showPersonasModal = true;
      }
      if (table === 'autos') {
        this.showAutosModal = true;
      }
    },
    closeModal(table) {
      if (table === 'personas') {
        this.showPersonasModal = false;
      }
      if (table === 'autos') {
        this.showAutosModal = false;
      }
    },
    confirmDelete(table) {
      const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este elemento?");

      if (confirmDelete) {
        let deleteUrl = '';

        if (table === 'personas') {
          deleteUrl = `http://127.0.0.1:8000/api/v1.0/persona/delete/${this.selectedItem.id}`;
        } else if (table === 'autos') {
          deleteUrl = `http://127.0.0.1:8000/api/v1.0/autos/delete/${this.selectedItem.id}`;
        }

        axios
          .delete(deleteUrl)
          .then(response => {
            if (response.status === 200) {
              if (table === 'personas') {
                this.personas = this.personas.filter(persona => persona.id !== this.selectedItem.id);
                this.closeModal(table);
              } else if (table === 'autos') {
                this.autos = this.autos.filter(auto => auto.id !== this.selectedItem.id);
                this.closeModal(table);
              }
              window.history.back();
              this.closeModal(table);
            }
          })
          .catch(error => {
            alert("Error al eliminar el elemento");
          });
      }
    },
  }
}
</script>

<style>
body {
  padding: 0;
  margin: 0;
  width: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #0d202b3a;
}

.title__container {
  text-align: center;
  color: white;
  width: 100%;
  display: flex;
  justify-content: center;
  margin-top: 1vh;
}

h1 {
  width: 20%;
  font-size: 20px;
  border-radius: 10px 10px 0px 0px;
  background-color: #0d202b;
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
  background-color: #0D202B;
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
h2{
  font-weight: bold;
  text-align: start;
  margin-bottom: 3vh;
}
p{
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