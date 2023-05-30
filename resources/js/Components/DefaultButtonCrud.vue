<template>
    <button :class="buttonClasses" @click="handleClick">
        <slot></slot>
    </button>
</template>
  
<script>
export default {
    name: 'DefaultButtonCrud',
    props: {
        color: {
            type: String,
            default: 'primary'
        },
        size: {
            type: String,
            default: 'medium'
        }
    },
    data() {
        return {
            showModal: false
        };
    },
    methods: {
        handleClick() {
            this.$emit('click');
        }
    },
    computed: {
        buttonClasses() {
            return [
                'crud-button',
                `crud-button--${this.color}`,
                `crud-button--${this.size}`
            ];
        }
    }
}
</script>
  
<style scoped>
.crud-button {
    padding: 8px 20px;
    border: none;
    margin: 2px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: .5s;
}

.crud-button--primary {
    background-color: #007bff;
    color: white;
}

.crud-button--secondary {
    background-color: #70b475;
    color: white;
}

.crud-button--delete {
    background-color: #f32020;
    color: white;
}

.crud-button--large {
    font-size: 1.2rem;
}

.crud-button--medium {
    font-size: 1rem;
}

.crud-button--small {
    font-size: 0.8rem;
}

.crud-button:hover {
    background-color: #0D202B;
}
</style>