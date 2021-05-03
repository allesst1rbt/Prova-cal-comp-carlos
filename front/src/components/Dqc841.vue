<template lang="">
    <div class="col-12">
        <div class="col-12" >
        <table class="table table-bordered  table-dark mt-3">
        
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Fart_Part_No</th>
            <th scope="col">Parts_No</th>
            <th scope="col">Unt_Usg</th>
            <th scope="col">Description</th>
            <th scope="col">Ref_Designator</th>
            <th scope="col">Atualizado em</th>
            <th scope="col">Criado em</th>
            <th scope="col">Editar</th>
            <th scope="col">Apagar</th>
            <th scope="col"><b-button v-b-modal="'modal-create'" v-on:click="clearProps()"   variant="outline-success">Adicionar</b-button></th>
            
            </tr>
        </thead>
            <tbody v-for="dqc in dqc841" :key="dqc.ID">               
                <tr>
                <th scope="row">{{dqc.ID}}</th>
                <td>{{dqc.FART_PART_NO}}</td>
                <td>{{dqc.PARTS_NO}}</td>
                <td>{{dqc.UNT_USG}}</td>
                <td>{{dqc.DESCRIPTION}}</td>
                <td>{{dqc.REF_DESIGNATOR}}</td>
                <td>{{dqc.UPDATE_DT | formatDate }}</td>
                <td>{{dqc.CREATE_DT | formatDate }}</td>
                <td><b-button v-b-modal="'modal-update'" v-on:click="update(dqc.PARTS_NO,dqc.UNT_USG,dqc.DESCRIPTION,dqc.REF_DESIGNATOR,dqc.ID)" variant="outline-primary"><i class="fas fa-pen"></i></b-button></td>
                <td><b-button v-on:click="delet(dqc.ID)" variant="outline-danger"><i class="fas fa-trash"></i></b-button></td>
                </tr>

            </tbody>
        </table>
        <b-modal  @ok="updateApi" id="modal-update">
              <label >Fart_Part_No:</label>
             <b-form-select v-model="selected" class="mb-3">
                <b-form-select-option :value="null" disabled>-- Selecione  um valor --</b-form-select-option>
                <b-form-select-option  v-for="dqc in dqc84" :key="dqc.ID" :value="dqc.ID">{{dqc.FART_PART_NO}}</b-form-select-option>
            </b-form-select>
             <label >Parts_No:</label>
             <b-form-input v-model="parts"  :state="partsChecker" ></b-form-input>
             <label >Unt_Usg:</label>
             <b-form-input v-model="unt" :type="'number'" :state="untChecker" ></b-form-input>
              <label >Description:</label>
             <b-form-input v-model="des" :type="'text'" :state="desChecker" ></b-form-input>
             <label >Ref_Designator:</label>
             <b-form-input v-model="ref_des" :type="'text'"  ></b-form-input>
        </b-modal>
         <b-modal  @ok="createApi" id="modal-create">
             <label >Fart_Part_No:</label>
             <b-form-select v-model="selected" class="mb-3">
                <b-form-select-option :value="null" disabled>-- Selecione  um valor --</b-form-select-option>
                <b-form-select-option  v-for="dqc in dqc84" :key="dqc.ID" :value="dqc.ID">{{dqc.FART_PART_NO}}</b-form-select-option>
            </b-form-select>
             <label >Parts_No:</label>
             <b-form-input v-model="parts"  :state="partsChecker" ></b-form-input>
             <label >Unt_Usg:</label>
             <b-form-input v-model="unt" :type="'number'" :state="untChecker" ></b-form-input>
              <label >Description:</label>
             <b-form-input v-model="des" :type="'text'" :state="desChecker" ></b-form-input>
             <label >Ref_Designator:</label>
             <b-form-input v-model="ref_des" :type="'text'"  ></b-form-input>
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
  name: "dqc841",
  data() {
    return {
      dqc841: null,
      dqc84: null,
      id: null,
      parts: "",
      unt: 0,
      des: "",
      ref_des: "",
      mensagem: "",
      selected: null,
    };
  },
  mounted() {
    axios
      .get("/dqc841")
      .then((response) => {
        this.dqc841 = response.data.data;
      })
      .catch((error) => {
        this.mensagem = error.response.data.mensagem.errorInfo[2];
        this.showModalErro();
      });
    axios
      .get("/dqc84")
      .then((response) => {
        this.dqc84 = response.data.data;
        console.log(this.dqc84);
      })
      .catch((error) => {
        this.mensagem = error.response.data.mensagem.errorInfo[2];
        this.showModalErro();
      });
  },
  methods: {
    delet: function (id) {
      axios
        .delete(`/dqc841/${id}`)
        .then((response) => {
          alert(response.data.mensagem);
          window.location.reload();
        })
        .catch((error) => {
          this.mensagem = error.response.data.mensagem.errorInfo[2];
          this.showModalErro();
        });
    },
    update: function (parts, unt, des, ref_des, id) {
      this.unt = unt;
      this.parts = parts;
      this.des = des;
      this.ref_des = ref_des;
      this.id = id;
    },
    updateApi() {
      if (
        this.parts.length <= 15 &&
        this.parts.length >= 3 &&
        this.unt.length > 0 &&
        this.selected != null
      ) {
        axios
          .put(`dqc841/${this.id}`, {
            part_no: this.parts,
            unt_usg: this.unt,
            description: this.des,
            ref_designator: this.ref_des,
            fart_id: this.selected,
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
        this.parts.length <= 15 &&
        this.parts.length >= 3 &&
        this.unt.length > 0 &&
        this.selected != null
      ) {
        axios
          .post(`dqc841/`, {
            part_no: this.parts,
            unt_usg: this.unt,
            description: this.des,
            ref_designator: this.ref_des,
            fart_id: this.selected,
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
    showModalErro() {
      this.$refs["modal-erro"].show();
    },
    clearProps() {
      this.parts = "";
      this.unt = 0;
      this.des = "";
      this.ref_des = "";
      this.selected = null;
    },
  },
  computed: {
    partsChecker() {
      return this.parts.length <= 15
        ? this.parts.length >= 3
          ? true
          : false
        : false;
    },
    untChecker() {
      return this.unt.length > 0 ? true : false;
    },
    desChecker() {
      return this.des.length > 0 ? true : false;
    },
  },
};
</script>
<style lang="">
</style>