<template>
    <div class="card mt-4 p-4">
        <h2>Your Profile</h2>
        <p><strong>Name:</strong> {{ user.name }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },
};
</script>

<style scoped>
.card {
    background-color: var(--white);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
