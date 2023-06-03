<template lang="">
    <navigation-link href="/index" class="nav">Personas</navigation-link>
    <navigation-link @click="createItem('autos')" class="nav2">Crear Auto</navigation-link>

    <div class="container">
        <div class="container__tables">
            <div class="title__container">
                <h1>Autos</h1>
                <!-- <DefaultButtonCrud color="primary" size="small" @click="goPerson()">&#60; Personas</DefaultButtonCrud> -->
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
              <td class="descripcion-column">{{ auto.descripcion }}</td>
              <td>{{ auto.persona_id }}</td>
              <td>
                <DefaultButtonCrud color="secondary" size="small" @click="editItem('autos', auto)">Editar
                </DefaultButtonCrud>
                <DefaultButtonCrud color="delete" size="small" @click="deleteItem(auto)">
                  Eliminar
                </DefaultButtonCrud>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
            <!-- <div class="title__container2">
                <DefaultButtonCrud color="primary" size="small" @click="createItem('autos')">Crear Auto ></DefaultButtonCrud>
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
            autos: [],
        };
    },
    created() {
        this.fetchAutos();
    },
    methods: {
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
            if (table === 'autos') {
                window.location.href = '/createAuto';
            }
        },
        goPerson() {
            window.location.href = '/index';
        },
        editItem(table, auto) {
            if (table === 'autos' && auto) {
                window.location.href = `/updatePerson/${auto.persona_id}/updateAuto/${auto.id}`;
            }
        },
        deleteItem(auto) {
            const deleteUrl = `http://127.0.0.1:8000/api/v1.0/autos/delete/${auto.id}`;

            axios
                .delete(deleteUrl)
                .then(response => {
                    if (response.status === 201) {
                        const index = this.autos.findIndex(p => p.id === auto.id);
                        if (index !== -1) {
                            this.autos.splice(index, 1);
                            this.updatePersonasTable();
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },

        updatePersonasTable() {
            axios.get('http://127.0.0.1:8000/api/v1.0/autos')
                .then(response => {
                    this.autos = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>
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

.descripcion-column {
    max-width: 70vh;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 0vh 2vh;
    font-style: italic;
}

thead {
    position: sticky;
    top: 0;
    background-color: #1e212c;
    color: white;
    width: 100%;
}

th {
    padding: 1vh 2vh;
}

tbody tr:hover {
    background-color: #adb3af;
    color: rgb(0, 0, 0);
    cursor: pointer;
    padding: 1vh 0vh;
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