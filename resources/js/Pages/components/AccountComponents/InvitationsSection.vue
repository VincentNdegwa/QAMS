<template>
    <div class="mt-4 p-1">
        <h2>Invitations</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Invited User</th>
                    <th scope="col">Status</th>
                    <th scope="col">Company</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="invitation in invitations" :key="invitation.id">
                    <td>{{ invitation.name }}</td>
                    <td>
                        <div
                            v-if="invitation.status == 'closed'"
                            class="badge bg-danger"
                        >
                            {{ invitation.status }}
                        </div>
                        <div
                            v-else-if="invitation.status == 'open'"
                            class="badge bg-green text-dark"
                        >
                            {{ invitation.status }}
                        </div>
                            <div
                            v-else
                            class="badge bg-yellow text-dark"
                        >
                            {{ invitation.status }}
                        </div>
                    </td>
                    <td>{{ invitation.company }}</td>
                    <td>
                        <button
                            class="btn btn-danger text-light m-1"
                            :disabled="invitation.status !== 'open'"
                            @click="$emit('update-status', invitation.id)"
                        >
                            Cancel
                        </button>
                        <button
                            class="btn btn-secondary text-dark m-1"
                            :disabled="invitation.status !== 'joined'"
                            @click="$emit('update-role', invitation.id)"
                        >
                            Update
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        invitations: Array,
    },
};
</script>

<style scoped>
.table thead {
    background-color: var(--dark);
    color: var(--white);
}
</style>
