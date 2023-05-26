<template>
    <div class="container">
        <div class="upper-table">
            <div class="buttons mb-5">
                <AddBtn @click="modal = !modal">Add New Book</AddBtn>
            </div>

            <div class="search-container message">
                <input
                    type="text"
                    class="search-input"
                    placeholder="Search..."
                    v-model="search"
                    @input="searchBook()"
                />
                <!-- <button class="search-button">Search</button> -->
            </div>

            <div v-if="success" class="alert alert-success message">
                {{ success }}
            </div>
        </div>

        <div v-if="books != ''" class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Number off copies</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in books" :key="book.id">
                        <td>{{ book.title }}</td>
                        <td>{{ book.author }}</td>
                        <td>{{ book.num_off_copies }}</td>
                        <td>
                            <i
                                @click="deleteBook(book.id)"
                                class="fa-solid fa-trash"
                                style="color: #e9220c"
                            ></i>
                            <i
                                @click="openEditModal(book.id)"
                                class="fa-sharp fa-solid fa-pen-to-square"
                                style="color: #2c79dd"
                            ></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <center v-else><h4>No books found</h4></center>
    </div>

    <Modal
        v-if="modal"
        @closeModal="modal = !modal"
        @reloadBooks="getBooks()"
        @updateMsg="updateSuccessMsg($event)"
    >
    </Modal>
    <EditModal
        v-if="editModal"
        @closeModal="editModal = !editModal"
        @reloadBooks="getBooks()"
        :id="editId"
        @updateMsg="updateSuccessMsg($event)"
    ></EditModal>
</template>

<script>
import axios from "axios";
import AddBtn from "../componentsItem/AddBtn.vue";
import Modal from "../componentsItem/Modal.vue";
import EditModal from "../componentsItem/EditModal.vue";

export default {
    components: {
        AddBtn,
        Modal,
        EditModal,
    },

    data() {
        return {
            books: {},
            modal: false,
            success: "",
            editModal: false,
            editId: "",
            search: "",
        };
    },

    methods: {
        getBooks() {
            var self = this;
            return axios
                .get("/allBooks")
                .then(function (response) {
                    self.books = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        deleteBook(id) {
            axios
                .delete(`/deleteBook/${id}`)
                .then((response) => {
                    this.success = response.data.message;
                    this.getBooks();

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

            setTimeout(() => {
                this.hideSuccesMsg();
            }, 2000);
        },
        searchBook() {
            var self = this;
            if (this.search != "") {
                return axios
                    .get(`/searchBook/${this.search}`)
                    .then(function (response) {
                        self.books = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                this.getBooks();
            }
        },
    },

    mounted() {
        this.getBooks();
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
