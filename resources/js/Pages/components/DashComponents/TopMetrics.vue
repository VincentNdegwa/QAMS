<template>
    <div class="col-12 col-md-3 mt-2">
        <div class="card border-0 card-dash">
            <div class="card-body text-center bg-dark">
                <div class="card-title h5 text-secondary">
                    {{ name }} <span v-html="renderIcon(name)"></span>
                </div>
                <div class="card-subtitle p">
                    {{ description }}
                </div>
                <div class="card-text mt-2 h1 text-primary">
                    3
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        description: String
    },
    methods: {
        renderIcon(name) {

            switch (name) {
                case "Organisation":
                    return '<i class="bi bi-building-fill"></i>';
                case "Issues":
                    return '<i class="bi bi-exclamation-triangle-fill"></i>';
                case "Tests":
                    return '<i class="bi bi-screwdriver"></i>';
                case "Projects":
                    return '<i class="bi bi-kanban-fill"></i>';
                default:
                    return '';
            }
        }
    }
}
</script>
<style>
.card {
    box-shadow: 2px 3px 20px rgba(0, 0, 0, 0.3);
}
.card-dash{
    min-height: 200px !important;
    height: max-content !important;
}
</style>
