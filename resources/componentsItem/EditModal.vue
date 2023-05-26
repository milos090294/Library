<template>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeBtn()">&times;</span>
            <form id="myForm" @submit.prevent="editBook()">
                <h2>Edit Book</h2>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        v-model="title"
                    />
                    <small>{{ titleError }}</small>
                </div>

                <div class="form-group">
                    <label for="author">Author:</label>
                    <input
                        type="text"
                        id="author"
                        name="author"
                        v-model="author"
                    />
                    <small>{{ authorError }}</small>
                </div>

                <div class="form-group">
                    <label for="copies">Number of Copies:</label>
                    <input
                        type="number"
                        id="copies"
                        name="num_off_copies"
                        v-model="num"
                        min="3"
                        required
                    />
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
            title: "",
            author: "",
            num: "",
            titleError: "",
            authorError: "",
        };
    },
    props: ["id"],
    methods: {
        closeBtn() {
            this.$emit("closeModal");
        },
        editBook() {
            this.titleError = "";
            this.authorError = "";

            let data = {
                title: this.title,
                author: this.author,
                num_off_copies: this.num,
            };

            axios
                .put(`/updateBook/${this.id}`, data)
                .then((response) => {
                    this.$emit("reloadBooks");
                    this.$emit("closeModal");
                    this.$emit("updateMsg", response.data.message);
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        error.response.data.errors.hasOwnProperty("title")
                            ? (this.titleError =
                                  error.response.data.errors.title[0])
                            : "";

                        error.response.data.errors.hasOwnProperty("author")
                            ? (this.authorError =
                                  error.response.data.errors.author[0])
                            : "";
                    } else {
                        console.error(error);
                    }
                });
        },
        getEditData() {
            axios
                .get(`/getBook/${this.id}`)
                .then((response) => {
                    this.title = response.data.title;
                    this.author = response.data.author;
                    this.num = response.data.num_off_copies;
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
