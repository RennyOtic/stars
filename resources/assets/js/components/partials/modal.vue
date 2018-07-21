<template>
  <div class="modal fade" :id="id" tabindex="-1" role="dialog"> <!--  data-backdrop="static" -->
    <div class="modal-dialog" :class="'modal-'+w" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><slot name="modal-title">Modal title.</slot></h4>
        </div>
        <div class="modal-body">
          <slot name="modal-body">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt beatae esse velit ipsa sunt incidunt aut voluptas, nihil reiciendis maiores eaque hic vitae saepe voluptatibus. Ratione veritatis a unde autem!
            </p>
          </slot>
        </div>
        <div class="modal-footer">
          <slot name="modal-btn">
            <button type="button" class="btn btn-primary btn-raised" data-dismiss="modal">
              <span class="fa fa-close"></span> Cerrar
            </button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'modal',
    props: ['id', 'w']
  }
</script>
