<template lang="">
    <div class="col-5">
       
      <b-card class="mt-3" bg-variant="dark" text-variant="white" title="Relatorio prova cal-comp">
        <b-card-text>
         <b-form-input  v-model="email" placeholder="Email@example.com"></b-form-input>
        </b-card-text>
        <b-button v-on:click="enviar()"   variant="outline-info">Enviar relatorio por email</b-button>
        <downloadCsv class="ml-5" :json-data="json_data"
          :csv-title="'ReportDaProva'">
          <b-button  variant="outline-primary">Baixar relatorio</b-button>
      </downloadCsv>
      
      </b-card>
      <b-modal ref="modal-erro"  id="modal-erro">
             {{this.mensagem}}
        </b-modal>
    </div>
</template>

<script>
import axios from "../axios";
export default {
  name: "Report",
  data() {
    return {
      json_data: [{}],
      email: "",
      mensagem: "",
    };
  },
  mounted() {
    axios
      .post("/generate")
      .then((response) => {
        this.json_data = response.data.data;
      })
      .catch((error) => {
        this.mensagem = error.response.data.mensagem.errorInfo[2];
        this.showModalErro();
      });
  },
  methods: {
    enviar: function () {
      axios
        .post(`/generate`, { email: this.email })
        .then((response) => {
          alert(response.data.mensagem);
          window.location.reload();
        })
        .catch((error) => {
          this.mensagem = error.response.data.mensagem.errorInfo[2];
          this.showModalErro();
        });
    },
    showModalErro() {
      this.$refs["modal-erro"].show();
    },
  },
};
</script>
<style lang="">
</style>