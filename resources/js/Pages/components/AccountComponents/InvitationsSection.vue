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
          <td>{{ invitation.status }}</td>
          <td>{{ invitation.company }}</td>
          <td>
            <button
              class="btn btn-success"
              :disabled="invitation.status !== 'open'"
              @click="$emit('update-status', invitation.id)"
            >
              Update Status
            </button>
            <button
              class="btn btn-warning text-dark"
              :disabled="invitation.status !== 'joined'"
              @click="$emit('update-role', invitation.id)"
            >
              Update Role
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
    invitations: Array
  }
};
</script>

<style scoped>
.table thead {
  background-color: var(--dark);
  color: var(--white);
}

.btn-success {
  background-color: var(--green);
  border-color: var(--green);
}

.btn-warning {
  background-color: var(--yellow);
  border-color: var(--yellow);
}
</style>
