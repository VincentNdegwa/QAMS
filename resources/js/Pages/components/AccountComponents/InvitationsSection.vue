<template>
  <div class="mt-4 p-1">
    <h2>Invitations</h2>
    <table class="table table-dark">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Invited email</th>
          <th scope="col">Status</th>
          <th scope="col">Company</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="invitation in invitations" :key="invitation.id">
          <td>{{ invitation.invited_email }}</td>
          <td>
            <div v-if="invitation.status === 'closed'" class="badge bg-danger">
              {{ invitation.status }}
            </div>
            <div v-else-if="invitation.status === 'open'" class="badge bg-green text-dark">
              {{ invitation.status }}
            </div>
            <div v-else class="badge bg-yellow text-dark">
              {{ invitation.status }}
            </div>
          </td>
          <td>{{ invitation.company.name }}</td>
          <td>
            <i
              @click="viewOptions(invitation, $event)"
              class="bi bi-three-dots-vertical h6 border border-1 p-1 rounded-1 pointer"
            ></i>
            <div
              v-if="localSelectedInvite && localSelectedInvite.id === invitation.id"
              class="d-flex flex-column position-absolute bg-dark p-1 rounded-2 text-light"
              :style="actionButtonStyle"
            >
              <div
                class="bg-danger text-light m-1 p-1 rounded pointer"
                :class="{ 'opacity-50': localSelectedInvite.status !== 'open' }"
                :disabled="localSelectedInvite.status !== 'open'"
                @click="$emit('update-status', localSelectedInvite.id)"
              >
                Cancel Invite
              </div>
              <div
                class="bg-secondary m-1 p-1 rounded pointer"
                :class="{ 'opacity-50': localSelectedInvite.status !== 'joined' }"
                :disabled="localSelectedInvite.status !== 'joined'"
                @click="$emit('update-role', localSelectedInvite.id)"
              >
                Update Invite
              </div>
            </div>
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
    selectedInvite: Object,
  },
  data() {
    return {
      localSelectedInvite: null,
      actionButtonStyle: {
        top: '0px',
        left: '0px',
      },
    };
  },
  methods: {
    viewOptions(invitation, event) {
      this.localSelectedInvite = invitation;
      this.$emit('viewOptions', invitation);

      // Calculate the position of the action buttons
      const rect = event.target.getBoundingClientRect();
      this.actionButtonStyle = {
        top: `${rect.bottom + window.scrollY}px`,
        left: `${rect.left + window.scrollX}px`,
      };
    },
  },
  watch: {
    selectedInvite(newVal) {
      this.localSelectedInvite = newVal;
    },
  },
};
</script>

<style scoped>
.table thead {
  background-color: var(--dark);
  color: var(--white);
}

.pointer {
  cursor: pointer;
}

.position-absolute {
  position: absolute;
  z-index: 1000;
}

.opacity-50 {
  opacity: 0.5;
}
</style>
