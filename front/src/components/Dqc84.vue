<template lang="">
    <div class="col-12">
        <div class="col-8" >
        <table class="table table-bordered  table-dark mt-3">
        
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Model</th>
            <th scope="col">Fart_Part_No</th>
            <th scope="col">Total_Location</th>
            <th scope="col">Atualizado em</th>
            <th scope="col">Criado em</th>
            <th scope="col">Editar</th>
            <th scope="col">Apagar</th>
            <th scope="col"><b-button v-b-modal="'modal-create'" v-on:click="clearProps()"  variant="outline-success">Adicionar</b-button></th>
            
            </tr>
        </thead>
            <tbody v-for="dqc in dqc84" :key="dqc.ID">               
                <tr>
                <th scope="row">{{dqc.ID}}</th>
                <td>{{dqc.MODEL}}</td>
                <td>{{dqc.FART_PART_NO}}</td>
                <td>{{dqc.TOTAL_LOCATION}}</td>
                <td>{{dqc.UPDATE_DT | formatDate }}</td>
                <td>{{dqc.CREATE_DT | formatDate }}</td>
                <td><b-button v-b-modal="'modal-update'" v-on:click="update(dqc.TOTAL_LOCATION,dqc.FART_PART_NO,dqc.ID)" variant="outline-primary"><i class="fas fa-pen"></i></b-button></td>
                <td><b-button v-on:click="delet(dqc.ID)" variant="outline-danger"><i class="fas fa-trash"></i></b-button></td>
                </tr>

            </tbody>
        </table>
        <b-modal  @ok="updateApi" id="modal-update">
             <label >Model:</label>
             <b-form-select v-model="selected" class="mb-3">
                 <b-form-select-option :value="null" disabled>-- Selecione o modelo --</b-form-select-option>
                <b-form-select-option  v-for="model in models" :key="model.ID" :value="model.ID">{{model.MODEL}}</b-form-select-option>
            </b-form-select>
             <label >Fart_Part_No:</label>
             <b-form-input v-model="fart"  :state="fartChecker" ></b-form-input>
             <label >Total_Location:</label>
             <b-form-input v-model="total" :type="'number'" :state="totalChecker" ></b-form-input>
        </b-modal>
         <b-modal  @ok="createApi" id="modal-create">
             <label >Model:</label>
             <b-form-select v-model="selected" class="mb-3">
                <b-form-select-option :value="null" disabled>-- Selecione o modelo --</b-form-select-option>
                <b-form-select-option  v-for="model in models" :key="model.ID" :value="model.ID">{{model.MODEL}}</b-form-select-option>
            </b-form-select>
             <label >Fart_Part_No:</label>
             <b-form-input v-model="fart"  :state="fartChecker" ></b-form-input>
             <label >Total_Location:</label>
             <b-form-input v-model="total" :type="'number'" :state="totalChecker" ></b-form-input>
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
  name: "Dqc84",
  data() {
    return {
      dqc84: null,
      models: null,
      fart: "",
      total: "",
      id: null,
      mensagem: "",
      selected: null,
    };
  },
  mounted() {
    axios
      .get("/dqc84")
      .then((response) => {
        this.dqc84 = response.data.data;
      })
      .catch((error) => {
        this.mensagem = error.response.data.mensagem.errorInfo[2];
        this.showModalErro();
      });
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
        .delete(`/dqc84/${id}`)
        .then((response) => {
          alert(response.data.mensagem);
          window.location.reload();
        })
        .catch((error) => {
          this.mensagem = error.response.data.mensagem.errorInfo[2];
          this.showModalErro();
        });
    },
    update: function (total, fart, id) {
      this.total = total;
      this.fart = fart;
      this.id = id;
    },
    updateApi() {
      if (
        this.fart.length <= 15 &&
        this.fart.length >= 3 &&
        this.total.length > 0 &&
        this.selected != null
      ) {
        axios
          .put(`dqc84/${this.id}`, {
            fart: this.fart,
            total: this.total,
            model_id: this.selected,
          })
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
      if (
        this.fart.length <= 15 &&
        this.fart.length >= 3 &&
        this.total.length > 0 &&
        this.selected != null
      ) {
        axios
          .post(`dqc84/`, {
            fart: this.fart,
            total: this.total,
            model_id: this.selected,
          })
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
      this.fart = "";
      this.total = 0;
      this.selected = null;
    },
    showModalErro() {
      this.$refs["modal-erro"].show();
    },
  },
  computed: {
    fartChecker() {
      return this.fart.length <= 15
        ? this.fart.length >= 3
          ? true
          : false
        : false;
    },
    totalChecker() {
      return this.total.length > 0 ? true : false;
    },
  },
};
</script>
<style lang="">
</style>