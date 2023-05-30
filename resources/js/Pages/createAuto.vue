<template>
  <div class="update-auto-container">
    <h1>Crear Nuevo Auto</h1>
    <form @submit="createAuto" class="update-auto-form">
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
        <label for="color">Persona:</label>
        <input type="text" id="color" v-model="persona_id" required>
      </div>
      <div>
        <button type="submit">Crear Auto</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      marca: '',
      modelo: '',
      color: '',
      persona_id: ''
    };
  },
  methods: {
    createAuto() {
      axios.post(`http://127.0.0.1:8000/api/v1.0/persona/${this.persona_id}/autos/create`, {
        marca: this.marca,
        modelo: this.modelo,
        color: this.color,
        persona_id: this.persona_id
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