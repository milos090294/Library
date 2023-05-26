<template>
    <div class="container w-50">
        <div v-if="success" class="alert alert-success">
            {{ success }}
        </div>

        <center><h2 class="mt-4 mb-3 fw-bold">Return a Book</h2></center>
        <form @submit.prevent="returnBook()">
            <div v-if="members != ''" class="mb-3">
                <label for="memberSelect" class="form-label"
                    >Member who borrowed the book:</label
                >
                <select
                    class="form-select"
                    id="memberSelect"
                    v-model="selectedMember"
                    @change="getBooks()"
                >
                    <option
                        v-for="member in members"
                        :key="member.id"
                        :value="member.id"
                    >
                        {{ member.name }}
                    </option>
                </select>
            </div>
            <div v-else class="mb-3">
                <p>There are no members who owe the book</p>
            </div>
            <small> {{ memberError }}</small>

            <div v-if="selectedMember != ''" class="mb-3">
                <label for="bookSelect" class="form-label"
                    >Select a Book:</label
                >
                <select
                    class="form-select"
                    id="bookSelect"
                    v-model="selectedBook"
                >
                    <option
                        v-for="book in books"
                        :key="book.id"
                        :value="book.book_id"
                    >
                        {{ book.title }}
                    </option>
                </select>
            </div>
            <small> {{ bookError }}</small>

            <center>
                <button
                    :disabled="!members || members.length === 0"
                    type="submit"
                    class="submit mt-4"
                >
                    Submit
                </button>
            </center>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            bookError: "",
            memberError: "",
            books: "",
            members: "",
            selectedBook: "",
            selectedMember: "",
            success: "",
        };
    },
    methods: {
        getBooks() {
            var self = this;
            return axios
                .get(`/membersBooks/${this.selectedMember}`)
                .then(function (response) {
                    self.books = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getMembers() {
            var self = this;
            return axios
                .get("/allBorrowMembers")
                .then(function (response) {
                    self.members = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        returnBook() {
            var self = this;

            let data = {
                book: this.selectedBook,
                member: this.selectedMember,
            };

            axios
                .post("/returnBook", data)
                .then((response) => {
                    self.selectedMember = "";
                    self.getMembers();
                    self.success = response.data.message;
                    self.hideSuccessMsg();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        error.response.data.errors.hasOwnProperty("book")
                            ? (this.bookError =
                                  error.response.data.errors.book[0])
                            : "";

                        error.response.data.errors.hasOwnProperty("member")
                            ? (this.memberError =
                                  error.response.data.errors.member[0])
                            : "";
                    } else {
                        console.error(error);
                    }
                });
        },
        hideSuccessMsg() {
            setTimeout(() => {
                this.success = "";
            }, 2000);
        },
    },

    mounted() {
        this.getMembers();
    },
};
</script>

<style scoped>
h2 {
    background: linear-gradient(to right, #00ff00, #008000);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 35px;
    font-weight: bold;
    margin-top: 30px;
    margin-bottom: 20px;
}

.submit {
    background: linear-gradient(
        0deg,
        rgba(20, 167, 62, 1) 0%,
        rgba(102, 247, 113, 1) 100%
    );
    border: none;
    width: 150px;
    border-radius: 20px;
    padding: 10px 20px;
    color: white;
    font-weight: bold;
}

.submit:hover {
    opacity: 0.8;
}

small {
    color: rgb(212, 59, 59);
}
p {
    color: #168416ae;
    font-size: larger;
}
</style>
