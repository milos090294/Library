<template>
    <div class="container">
        <marquee v-if="lateMembers != ''" behavior="sliding" direction="left" scrollamount="12">
            <div class="paragraph-div">
                <p>Members who are late in returning their books:</p>
                <p v-for="late in lateMembers" :key="late.id">
                    &nbsp; {{ late.name }} &nbsp;
                </p>
            </div>
        </marquee>
        <marquee scrollamount="12" class="second-marque" v-else> No one is late in returning a book </marquee>

        <div class="upper-table">
            <div class="buttons mb-5">
                <AddBtn @click="modal = !modal">Add New Member</AddBtn>
            </div>

            <div class="search-container message">
                <input
                    type="text"
                    class="search-input"
                    placeholder="Search..."
                    v-model="search"
                    @input="searchMember()"
                />
                <!-- <button class="search-button">Search</button> -->
            </div>

            <div v-if="success" class="alert alert-success message">
                {{ success }}
            </div>
        </div>

        <div v-if="members != ''" class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Borrowed Books</th>
                        <th scope="col">Card Number</th>
                        <th scope="col">Date of Membership</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="member in members" :key="member.id">
                        <td>{{ member.name }}</td>
                        <td>{{ member.phone }}</td>
                        <td>{{ member.address }}</td>
                        <td>{{ member.borrowed_books }}</td>
                        <td>{{ member.card_number }}</td>
                        <td>{{ member.created_at.substring(0, 10) }}</td>
                        <td>
                            <i
                                @click="deleteMember(member.id)"
                                class="fa-solid fa-trash"
                                style="color: #e9220c"
                            ></i>
                            <i
                                @click="openEditModal(member.id)"
                                class="fa-sharp fa-solid fa-pen-to-square"
                                style="color: #2c79dd"
                            ></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <center v-else><h4>No Members found</h4></center>
    </div>

    <MemberModal
        v-if="modal"
        @closeMemberModal="modal = !modal"
        @reloadMembers="getMembers()"
        @updateMemberMsg="updateSuccessMsg($event)"
    ></MemberModal>
    <EditMember
        v-if="editModal"
        @reloadMembers="getMembers()"
        @closeMemberModal="editModal = !editModal"
        @updateMemberMsg="updateSuccessMsg($event)"
        :id="editId"
    ></EditMember>
</template>

<script>
import AddBtn from "../componentsItem/AddBtn.vue";
import MemberModal from "../componentsItem/MemberModal.vue";
import EditMember from "../componentsItem/EditMember.vue";
import axios from "axios";

export default {
    components: {
        AddBtn,
        MemberModal,
        EditMember,
    },

    data() {
        return {
            modal: false,
            editModal: false,
            success: "",
            members: "",
            editId: "",
            search: "",
            lateMembers: "",
        };
    },
    methods: {
        deleteMember(id) {
            axios.delete(`deleteMember/${id}`).then((response) => {
                this.success = response.data.message;
                this.getMembers();
                setTimeout(() => {
                    this.hideSuccesMsg();
                }, 2000);
            });
        },
        openEditModal(id) {
            this.editModal = true;
            this.editId = id;
        },
        getMembers() {
            var self = this;
            return axios
                .get("/allMembers")
                .then(function (response) {
                    self.members = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateSuccessMsg(value) {
            this.success = value;

            setTimeout(() => {
                this.hideSuccesMsg();
            }, 2000);
        },
        hideSuccesMsg() {
            this.success = "";
        },
        searchMember() {
            var self = this;
            if (this.search != "") {
                axios
                    .get(`/searchMember/${this.search}`)
                    .then((response) => {
                        self.members = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                this.getMembers();
            }
        },
        getLateMembers() {
            var self = this;
            axios
                .get("/lateMembers")
                .then((response) => {
                    self.lateMembers = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    mounted() {
        this.getMembers();
        this.getLateMembers();
    },
};
</script>

<style scoped>
i {
    margin-right: 8px;
    cursor: pointer;
}

.upper-table {
    display: flex;
    flex-direction: row;
    widows: 100%;
}

.message {
    height: 100%;
    margin-left: 10px;
}

.search-container {
    display: flex;
    align-items: center;
}

.search-input {
    padding: 10px;
    border-radius: 20px;
    border: none;
    font-size: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex: 1;
}

.search-button {
    padding: 10px 20px;
    margin-left: 10px;
    border-radius: 20px;
    border: none;
    background-color: #4caf50;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Optional: Add some hover effects */
.search-button:hover {
    background-color: #45a049;
}

h4 {
    color: rgb(214, 65, 65);
}

marquee {
    margin-bottom: 15px;
    border: 2px solid #45a049;
    color: rgb(214, 65, 65);
    padding: 8px;
}

.paragraph-div {
    display: flex;
}


.second-marque {

    color: rgb(70, 133, 236);

}

</style>
