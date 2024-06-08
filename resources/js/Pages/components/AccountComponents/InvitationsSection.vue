<template>
    <div class="mt-4 p-1">
        <h2>Invitations</h2>
        <table class="table table-dark">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th scope="col">Invited email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Organisation</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(invitation, index) in invitationdata" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td v-if="invitation.invited_email">
                        {{ invitation.invited_email }}
                    </td>
                    <td v-else>---</td>
                    <td>
                        <div v-if="invitation.status === 'closed'" class="badge bg-danger">
                            {{ invitation.status }}
                        </div>
                        <div v-else-if="invitation.status === 'joined'" class="badge bg-green text-dark">
                            {{ invitation.status }}
                        </div>
                          <div v-else-if="invitation.status === 'opened'" class="badge bg-yellow text-dark">
                            {{ invitation.status }}
                        </div>
                        <div v-else class="badge bg-danger text-dark">
                            {{ invitation.status }}
                        </div>
                    </td>
                    <td>{{ invitation.company.name }}</td>
                    <td>
                        <i @click="viewOptions(invitation, $event)" ref="optionRef"
                            class="bi bi-three-dots-vertical h6 border border-1 p-1 rounded-1 pointer"></i>
                        <div v-if="
                            localSelectedInvite &&
                            localSelectedInvite.id === invitation.id
                        " class="d-flex flex-column position-absolute bg-dark p-1 rounded-2 text-light"
                            :style="actionButtonStyle">
                            <div v-if="invitation.status === 'opened'" class="text-danger invite-action pointer rounded-1 h6">
                                <i class="bi bi-x-square"></i>
                                Cancel Invite
                            </div>
                              <div v-if="invitation.status === 'expired' || invitation.status === 'closed'" class="text-danger invite-action pointer rounded-1 h6">
                                <i class="bi bi-x-square"></i>
                                Delete Invite
                            </div>
                            <div v-if="invitation.status === 'joined'" class="text-danger invite-action pointer rounded-1 h6">
                                <i class="bi bi-x-square"></i>
                                Remove User
                            </div>
                            <div v-if="invitation.status === 'joined'" class="text-green invite-action pointer rounded-1 h6">
                                <i class="bi bi-pencil-square"></i>
                                Edit Role
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex accordion-body flex-row justify-content-between text-light">
            <div class="row-change">
                <span class="text-light"> Rows per page </span>
                <select @change="performSearchAndFilter" class="form bg-dark text-light" v-model="rows_per_page">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                </select>
            </div>
            <div class="pager-nav d-flex align-items-center g-2">
                <button :disabled="startPage === 1" @click="previousPage" class="bg-primary p-1 rounded-circle">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="count">{{ current_page }} of {{ endPage }}</div>
                <button @click="nextPage" :disabled="startPage == invitations.last_page"
                    class="bg-primary p-1 rounded-circle">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        invitations: Object,
        selectedInvite: Object,
        user_id: Number,
    },
    data() {
        return {
            localSelectedInvite: null,
            actionButtonStyle: {
                top: "0px",
                left: "0px",
            },
            invitationdata: this.invitations.data,
            current_page: this.invitations.current_page,
            startPage: this.invitations.from,
            endPage: this.invitations.last_page,
            rows_per_page: 10,
        };
    },
    methods: {
        viewOptions(invitation, event) {
            this.localSelectedInvite = invitation;
            this.$emit("viewOptions", invitation);

            // Calculate the position of the action buttons
            const rect = event.target.getBoundingClientRect();
            this.actionButtonStyle = {
                top: `${rect.bottom + window.scrollY}px`,
                left: `${rect.left + window.scrollX}px`,
            };
        },
        performSearchAndFilter() {
            let data = {
                user_id: this.user_id,
                page: this.current_page,
                rows_per_page: this.rows_per_page,
            };
            axios
                .post("/api/account/paginate", data)
                .then((res) => {
                    if (!res.data.error) {
                        let newPageData = res.data.data.data;
                        this.invitationdata = newPageData;
                        (this.current_page = res.data.data.current_page),
                            (this.endPage = res.data.data.last_page);
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        previousPage() {
            this.current_page--;
            this.performSearchAndFilter();
            this.startPage = this.current_page;
        },
        nextPage() {
            this.current_page++;
            this.performSearchAndFilter();
            this.startPage = this.current_page;
        },
        handleClickOutside(event) {
            if (
                this.$refs.optionRef
            ) {
                let found = this.$refs.optionRef.includes(event.target)
                if (!found) { 
                    this.localSelectedInvite = null;
                }
            }
        },
    },
    watch: {
        selectedInvite(newVal) {
            this.localSelectedInvite = newVal;
        },
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.handleClickOutside);
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

.invite-action {
    padding: 0.4rem;
}

.invite-action:hover {
    background: var(--bs-black);
}

button {
    border: none;
}

button:disabled {
    background-color: #cccccc;
    /* Light gray background */
    color: #666666;
    /* Dark gray text */
    cursor: not-allowed;
    /* Show not-allowed cursor */
    opacity: 0.6;
    /* Slight transparency */
    border: none;
    /* Remove any border if present */
}
</style>
