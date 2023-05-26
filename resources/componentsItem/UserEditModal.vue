<template>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeBtn()">&times;</span>
            <form id="myForm" @submit.prevent="editUser()">
                <h2>Edit User</h2>
                <div class="form-group">
                    <label for="name">name:</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        v-model="name"
                    />
                    <small>{{ nameError }}</small>
                </div>

                <div class="form-group">
                    <label for="email">email:</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        v-model="email"
                    />
                    <small>{{ emailError }}</small>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select v-model="role" name="role" id="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <small>{{ roleError }}</small>
                </div>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            name: "",
            email: "",
            role: "",
            nameError: "",
            emailError: "",
            roleError: "",
        };
    },
    props: ["id"],
    methods: {
        closeBtn() {
            this.$emit("closeModal");
        },
        editUser() {
            this.nameError = "";
            this.emailError = "";
            this.roleError = "";

            let data = {
                name: this.name,
                email: this.email,
                role: this.role,
            };


            axios
                .put(`/updateUser/${this.id}`, data)
                .then((response) => {
                    this.$emit("reloadUsers");
                    this.$emit("closeUserModal");
                    this.$emit("updateUserMsg", response.data.message);
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        error.response.data.errors.hasOwnProperty("name")
                            ? (this.nameError =
                                  error.response.data.errors.name[0])
                            : "";

                        error.response.data.errors.hasOwnProperty("email")
                            ? (this.emailError =
                                  error.response.data.errors.email[0])
                            : "";
                        
                        error.response.data.errors.hasOwnProperty("role")
                            ? (this.roleError =
                                  error.response.data.errors.role[0])
                            : "";
                    } else {
                        console.error(error);
                    }
                });
        },
        getEditData() {
            axios
                .get(`/getUser/${this.id}`)
                .then((response) => {
                    this.name = response.data.name;
                    this.email = response.data.email;
                    this.role = response.data.role;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    mounted() {
        this.getEditData();
    },
};
</script>

<style scoped>
/* Modal Styles */
.modal {
    display: block;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: none;
    width: 80%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

.close {
    color: #aaa;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover,
.close:focus {
    color: #555;
}

form {
    display: flex;
    flex-direction: column;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 8px;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

button[type="submit"] {
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #4caf50;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

button[type="submit"]:focus {
    outline: none;
}

small {
    color: rgb(228, 40, 40);
}

/* Responsive Styles */
@media screen and (max-width: 600px) {
    .modal-content {
        width: 90%;
    }
}
</style>
