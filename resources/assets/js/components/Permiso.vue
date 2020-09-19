<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Categorías
          <button
            type="button"
            @click="abrirModal('persona', 'registrar')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="nombre">Nombre</option>
                  <option value="rut">Rut</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarPersona(1, buscar, criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarPersona(1, buscar, criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Rut</th>
                <th>Cargo</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Fono</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="persona in arrayPersona" :key="persona.id">
                <td>
                  <button
                    type="button"
                    @click="abrirModal('persona', 'actualizar', persona)"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="icon-pencil"></i>
                  </button>
                  &nbsp;
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    @click="dasactivarPersona"
                  >
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td v-text="persona.nombre"></td>
                <td v-text="persona.apellido"></td>
                <td v-text="persona.rut"></td>
                <td v-text="persona.cargo"></td>
                <td v-text="persona.direccion"></td>
                <td v-text="persona.email"></td>
                <td v-text="persona.fono"></td>

                <td>
                  <div v-if="persona.condicion">
                    <span class="badge badge-success">Activo</span>
                  </div>
                  <div v-else>
                    <span class="badge badge-danger">Desactivado</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="
                    cambiarPagina(pagination.current_page - 1, buscar, criterio)
                  "
                  >Ant</a
                >
              </li>
              <li
                class="page-item"
                v-for="page in pagesNumber"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(page, buscar, criterio)"
                  v-text="page"
                ></a>
              </li>

              <li
                class="page-item"
                v-if="pagination.current_page < pagination.last_page"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="
                    cambiarPagina(pagination.current_page + 1, buscar, crietrio)
                  "
                  >Sig</a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{ mostrar: modal }"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button
              type="button"
              class="close"
              @click="cerrarModal()"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              action=""
              method="post"
              enctype="multipart/form-data"
              class="form-horizontal"
            >
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Nombre</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="nombre"
                    class="form-control"
                    placeholder=" Nombre de persona"
                  />
                  <!-- <span class="help-block">(*) Ingrese el nombre de la persona</span>-->
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Apellido</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="apellido"
                    class="form-control"
                    placeholder=" Apellido"
                  />
                  <!-- <span class="help-block">(*) Ingrese el Apellido</span>-->
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Rut</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="rut"
                    class="form-control"
                    placeholder=" Numero de Rut"
                  />
                  <!-- <span class="help-block">(*) Ingrese su Rut</span> -->
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Cargo</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="cargo"
                    class="form-control"
                    placeholder=" Cargo"
                  />
                  <!--<span class="help-block">(*) Ingrese el Cargo</span> -->
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Dirección</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="direccion"
                    class="form-control"
                    placeholder="Direccion"
                  />
                  <!--<span class="help-block">(*) Ingrese la direccion</span> -->
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input"
                  >Email</label
                >
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="email"
                    class="form-control"
                    placeholder=" Email"
                  />
                  <!-- <span class="help-block">(*) Ingrese el Email</span> -->
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Telefono</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="fono"
                    class="form-control"
                    placeholder="Telefono"
                  />
                  <!-- <span class="help-block">(*) Ingrese el Telefono</span> -->
                </div>
              </div>
              <div v-show="errorPersona" class="form-group row div-error">
                <div class="text-center text-error" @click="cerrarModal()">
                  <div
                    v-for="error in errorMostrarMsjPersona"
                    :key="error"
                    v-text="error"
                  ></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              @click="cerrarModal()"
            >
              Cerrar
            </button>
            <button
              type="button"
              v-if="tipoAccion == 1"
              class="btn btn-primary"
              @click="registrarPersona()"
            >
              Guardar
            </button>
            <button
              type="button"
              v-if="tipoAccion == 2"
              class="btn btn-primary"
              @click="actualizarPersona()"
            >
              Actualizar
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
</template>

<script>
export default {
  data() {
    return {
      persona_id: 0,
      nombre: "",
      apellido: "",
      rut: "",
      cargo: "",
      direccion: "",
      email: "",
      fono: "",
      arrayPersona: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorPersona: 0,
      errorMostrarMsjPersona: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      offset: 3,
      criterio: "nombre",
      buscar: "",
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },
  methods: {
    listarPersona(page, buscar, criterio) {
      let me = this;
      var url =
        "/persona?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayPersona = respuesta.personas.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //actualizar la pagina actual
      me.pagination.current_page = page;
      //Enviar la peticion para visualizar la data de esa pagina
      me.listarPersona(page, buscar, criterio);
    },
    registrarPersona() {
      if (this.validarPersona()) {
        return;
      }
      let me = this;
      axios
        .post("/persona/registrar", {
          nombre: this.nombre,
          apellido: this.apellido,
          rut: this.rut,
          cargo: this.cargo,
          direccion: this.direccion,
          email: this.email,
          fono: this.fono,
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarPersona(1, "", nombre);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarPersona() {
      if (this.validarPersona()) {
        return;
      }
      let me = this;
      axios
        .put("/persona/actualizar", {
          nombre: this.nombre,
          apellido: this.apellido,
          rut: this.rut,
          cargo: this.cargo,
          direccion: this.direccion,
          email: this.email,
          fono: this.fono,
          id: this.persona_id,
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarPersona(1, "", "nombre");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    dasactivarPersona() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons
        .fire({
          title: "Estas seguro?",
          text: "¡No podrás revertir esto!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Sí, bórralo!",
          cancelButtonText: "No, cancelar!",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.value) {
            swalWithBootstrapButtons.fire(
              "¡Eliminado!",
              "Su archivo ha sido eliminado.",
              "éxito"
            );
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              "Cancelado",
              "Tu archivo está seguro :)",
              "error"
            );
          }
        });
    },
    validarPersona() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];

      if (!this.nombre)
        this.errorMostrarMsjPersona.push(
          "El nombre de la persona no puede estar vacio."
        );

      if (!this.apellido)
        this.errorMostrarMsjPersona.push(
          "El apellido de la persona no puede estar vacio."
        );

      if (!this.rut)
        this.errorMostrarMsjPersona.push(
          "El rut de la persona no puede estar vacio."
        );

      if (!this.cargo)
        this.errorMostrarMsjPersona.push(
          "El Cargo de la persona no puede estar vacio."
        );

      if (!this.direccion)
        this.errorMostrarMsjPersona.push(
          "La Dirección de la persona no puede estar vacio."
        );

      if (!this.email)
        this.errorMostrarMsjPersona.push(
          "El Email de la persona no puede estar vacio."
        );

      if (!this.fono)
        this.errorMostrarMsjPersona.push(
          "El Telefono de la persona no puede estar vacio."
        );

      if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

      return this.errorPersona;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.nombre = "";
      this.apellido = "";
      this.rut = "";
      this.cargo = "";
      this.direccion = "";
      this.email = "";
      this.fono = "";
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "persona": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Persona";
              this.nombre = "";
              this.apellido = "";
              this.rut = "";
              this.cargo = "";
              this.direccion = "";
              this.email = "";
              this.fono = "";
              this.tipoAccion = 1;
              break;
            }

            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualiozar persona";
              this.tipoAccion = 2;
              this.persona_id = data["id"];
              this.nombre = data["nombre"];
              this.apellido = data["apellido"];
              this.rut = data["rut"];
              this.cargo = data["cargo"];
              this.direccion = data["direccion"];
              this.email = data["email"];
              this.fono = data["fono"];
              break;
            }
          }
        }
      }
    },
  },
  mounted() {
    this.listarPersona(1, this.buscar, this.criterio);
  },
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important ;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
