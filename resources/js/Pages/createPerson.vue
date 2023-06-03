<template>
  <div class="update-auto-container">
    <div class="navContainer">
      <h1>Crear Nueva Persona</h1>
      <navigation-link href="/index" class="nav">Volver</navigation-link>
    </div>
    <form @submit="createPerson" class="update-auto-form">
      <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" v-model="nombre" required placeholder="Ingresa el nombre">
      </div>
      <div>
        <label for="ap_paterno">Apellido Paterno:</label>
        <input type="text" id="ap_paterno" v-model="ap_paterno" required placeholder="Ingresa apellido paterno">
      </div>
      <div>
        <label for="ap_materno">Apellido Materno:</label>
        <input type="text" id="ap_materno" v-model="ap_materno" required placeholder="Ingresa apellido materno">
      </div>
      <div>
        <button type="submit">Crear Persona</button>
      </div>
    </form>
  </div>
</template>
  
<script>
import NavigationLink from '../Components/NavLink.vue';
export default {
  components: {
    NavigationLink
  },
  data() {
    return {
      nombre: '',
      ap_paterno: '',
      ap_materno: ''
    };
  },
  methods: {
    createPerson() {
      axios.post('http://127.0.0.1:8000/api/v1.0/persona/create', {
        nombre: this.nombre,
        ap_paterno: this.ap_paterno,
        ap_materno: this.ap_materno
      })
        .then(response => {
          console.log(response.data);
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
.navContainer{
  display: flex;
  justify-content: space-between;
  width: 30%;
  margin-bottom: 1vh;
}
.nav{
  background-color: #0D202B;
  border-radius: 3px;
  align-items: center;
  text-align: center;
  transition: .4s;
  align-content: center;
  color: white;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.21);
}
.nav:hover{
  background-color: #0D202B;
  border-radius: 3px;
  align-items: center;
  text-align: center;
  transform: rotate(10deg);
  align-content: center;
  color: white;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.21);
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