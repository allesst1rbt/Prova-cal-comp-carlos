<template lang="">
    <div class="col-12">
      
        <div class="col-6" >

        <table class="table table-bordered  table-dark mt-3">
       
        <thead>
            <tr class="d-flex" >
            <th class="col-2">#</th>
            <th class="col-4">Model</th>
            <th class="col-2">Editar</th>
            <th class="col-2">Apagar</th>
            <th class="col-2"><b-button v-b-modal="'modal-create'"  v-on:click="clearProps()" variant="outline-success">Adicionar</b-button></th>
            
            </tr>
        </thead>
            <tbody v-for="model in models" :key="model.ID">               
                <tr class="d-flex">
                <th class="col-2">{{model.ID}}</th>
                <td class="col-4">{{model.MODEL}}</td>
                <td class="col-2"><b-button v-b-modal="'modal-update'" v-on:click="update(model.MODEL,model.ID)" variant="outline-primary"><i class="fas fa-pen"></i></b-button></td>
                <td class="col-2"><b-button v-on:click="delet(model.ID)" variant="outline-danger"><i class="fas fa-trash"></i></b-button></td>
                
                </tr>

            </tbody>
        </table>
        <b-modal  @ok="updateApi" id="modal-update">
             <label >Model:</label>
             <b-form-input v-model="name"  :state="nameChecker" ></b-form-input>
        </b-modal>
         <b-modal  @ok="createApi" id="modal-create">
             <label >Model:</label>
             <b-form-input v-model="name"  :state="nameChecker" ></b-form-input>
        </b-modal>
        <b-modal ref="modal-erro"  id="modal-erro">
             {{this.mensagem}}
        </b-modal>
       </div>
    </div>
</template>
<script>
import axios from "../axios";
export default {
  name: "DqcModels",
  data() {
    return {
      models: null,
      name: "",
      id: null,
      mensagem: "",
    };
  },
  mounted() {
    axios
      .get("/models")
      .then((response) => {
        this.models = response.data.data;
      })
      .catch((error) => {
        this.mensagem = error.response.data.mensagem.errorInfo[2];
        this.showModalErro();
      });
  },
  methods: {
    delet: function (id) {
      axios
        .delete(`/models/${id}`)
        .then((response) => {
          alert(response.data.mensagem);
          window.location.reload();
        })
        .catch((error) => {
          this.mensagem = error.response.data.mensagem.errorInfo[2];
          this.showModalErro();
        });
    },
    update: function (name, id) {
      this.name = name;
      this.id = id;
    },
    updateApi() {
      console.log("here");
      if (this.name.length <= 10 && this.name.length >= 3) {
        axios
          .put(`models/${this.id}`, { Model: this.name })
          .then((response) => {
            alert(response.data.mensagem);
            window.location.reload();
          })
          .catch((error) => {
            this.mensagem = error.response.data.mensagem.errorInfo[2];
          });
      } else {
        this.mensagem = "Não cumpre os requisitos por isso não sera cadastrado";
        this.showModalErro();
      }
    },
    createApi() {
      if (this.name.length <= 10 && this.name.length >= 3) {
        axios
          .post(`models/`, { model: this.name })
          .then((response) => {
            alert(response.data.mensagem);
            window.location.reload();
          })
          .catch((error) => {
            this.mensagem = error.response.data.mensagem.errorInfo[2];
            this.showModalErro();
          });
      } else {
        this.mensagem = "Não cumpre os requisitos por isso não sera cadastrado";
        this.showModalErro();
      }
    },
    clearProps() {
      this.name = "";
    },
    showModalErro() {
      this.$refs["modal-erro"].show();
    },
  },
  computed: {
    nameChecker() {
      return this.name.length <= 10
        ? this.name.length >= 3
          ? true
          : false
        : false;
    },
  },
};
</script>
<style lang="">
</style>