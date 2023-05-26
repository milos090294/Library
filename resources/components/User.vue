<template>
    <div class="container">
        <div class="upper-table">

            <div class="search-container message">
                <input
                    type="text"
                    class="search-input"
                    placeholder="Search..."
                    v-model="search"
                    @input="searchUser()"
                />
                <!-- <button class="search-button">Search</button> -->
            </div>
           
            <div v-if="success" class="alert alert-success message">
                {{ success }}
            </div>
        </div>

        <div v-if="users != ''" class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>
                            <i
                                @click="deleteUser(user.id)"
                                class="fa-solid fa-trash"
                                style="color: #e9220c"
                            ></i>
                            <i
                                @click="openEditModal(user.id)"
                                class="fa-sharp fa-solid fa-pen-to-square"
                                style="color: #2c79dd"
                            ></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <center v-else ><h4>No Users found</h4></center>
    </div>

    <UserEditModal
        v-if="editModal"
        @closeUserModal="editModal = !editModal"
        @reloadUsers="getUsers()"
        :id="editId"
        @updateUserMsg="updateSuccessMsg($event)"
    > </UserEditModal>
</template>

<script>
import axios from "axios";
import UserEditModal from "../componentsItem/UserEditModal.vue";

export default {
    components: {
    UserEditModal,
},

    data() {
        return {
            users: {},
            success: "",
            editModal: false,
            editId: "",
            search: "",
        };
    },

    methods: {
        getUsers() {
            var self = this;
            return axios
                .get("/getUsers")
                .then(function (response) {
                    self.users = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        deleteUser(id) {
            axios
                .delete(`/deleteUser/${id}`)
                .then((response) => {
                    this.success = response.data.message;
                    this.getUsers();

                    setTimeout(() => {
                        this.hideSuccesMsg();
                    }, 2000);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        hideSuccesMsg() {
            this.success = "";
        },
        openEditModal(id) {
            
            this.editModal = !this.editModal;
            this.editId = id;
        },
        updateSuccessMsg(value) {
            this.success = value;

            console.log(value);

            setTimeout(() => {
                this.hideSuccesMsg();
            }, 2000);
        },
        searchUser()
        {   
            var self = this;
            if(this.search != '')
            {

                axios.get(`/searchUser/${this.search}`)
                .then((response) => {
                    self.users = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })

            }else {
                this.getUsers();
            }
        }
    },

    mounted() {
        this.getUsers();
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

</style>
