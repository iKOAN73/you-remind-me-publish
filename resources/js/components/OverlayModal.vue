<template>
  <transition name="modal" appear>
    <div class="modal modal-overlay" @click.self="$emit('close')">
      <div class="modal-window bg-dark">
        <div class="modal-content bg-dark">
          <slot/>
        </div>
        <footer class="modal-footer">
          <slot name="footer">
            <button class="btn btn-primary" @click="$emit('close')">Close</button>
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>

<style lang="stylus" scoped>
.modal {
  &.modal-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(4px);
    background-color: rgba(0, 0, 0, 0.3);
  }

  &-window {
    border-radius: 4px;
    overflow: hidden;
    min-width: 70%;
  }

  &-content {
    padding: 10px 20px;
  }

  &-footer {
    padding: 10px;
    text-align: right;
  }
}

// オーバーレイのトランジション
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.4s;

  // オーバーレイに包含されているモーダルウィンドウのトランジション
  .modal-window {
    transition: opacity 0.4s, transform 0.4s;
  }
}

// // ディレイを付けるとモーダルウィンドウが消えた後にオーバーレイが消える
// .modal-leave-active {
//   transition: opacity 0.6s ease 0.4s;
// }

.modal-enter, .modal-leave-to {
  opacity: 0;

  .modal-window {
    opacity: 0;
    transform: translateY(-20px);
  }
}
</style>