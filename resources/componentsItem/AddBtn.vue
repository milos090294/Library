<template>
    <button class="button-add" role="button">
        <slot></slot>
    </button>
</template>

<script></script>

<style scoped>
.button-add {
    display: flex;
    align-items: center;
    font-family: inherit;
    font-weight: 500;
    font-size: 16px;
    margin-bottom: 10px;
    padding: 0.7em 1.4em 0.7em 1.1em;
    color: white;
    background: #ad5389;
    background: linear-gradient(
        0deg,
        rgba(20, 167, 62, 1) 0%,
        rgba(102, 247, 113, 1) 100%
    );
    border: none;
    box-shadow: 0 0.7em 1.5em -0.5em #14a73e98;
    letter-spacing: 0.05em;
    border-radius: 20em;
    cursor: pointer;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
}

.button-add:hover {
    box-shadow: 0 0.5em 1.5em -0.5em #14a73e98;
}

.button-add:active {
    box-shadow: 0 0.3em 1em -0.5em #14a73e98;
}
</style>
