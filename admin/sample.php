<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Search</title>
<style>
    #book-list {
        display: none;
        position: absolute;
        background-color: white;
        border: 1px solid #ddd;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1;
    }
    #book-list ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    #book-list ul li {
        padding: 8px 12px;
        cursor: pointer;
    }
    #book-list ul li:hover {
        background-color: #f3f3f3;
    }
</style>
</head>
<body>

<h2>Book Search</h2>

<input type="text" id="book-input" onkeyup="searchBooks()" placeholder="Type to search...">

<div id="book-list"></div>

<script>
const books = [
    "Harry Potter and the Philosopher's Stone",
    "The Great Gatsby",
    "To Kill a Mockingbird",
    "1984",
    "The Catcher in the Rye",
    "Animal Farm",
    "The Lord of the Rings",
    "Pride and Prejudice",
    "The Hobbit",
    "The Chronicles of Narnia"
];

function searchBooks() {
    const input = document.getElementById('book-input').value.toLowerCase();
    const bookList = document.getElementById('book-list');
    bookList.innerHTML = '';
    const matchingBooks = books.filter(book => book.toLowerCase().includes(input));
    if (matchingBooks.length > 0) {
        bookList.style.display = 'block';
        const ul = document.createElement('ul');
        matchingBooks.forEach(book => {
            const li = document.createElement('li');
            li.textContent = book;
            li.addEventListener('click', () => {
                document.getElementById('book-input').value = book;
                bookList.style.display = 'none';
            });
            ul.appendChild(li);
        });
        bookList.appendChild(ul);
    } else {
        bookList.style.display = 'none';
    }
}

document.addEventListener('click', function(event) {
    const bookInput = document.getElementById('book-input');
    const bookList = document.getElementById('book-list');
    if (event.target !== bookInput && event.target !== bookList) {
        bookList.style.display = 'none';
    }
});
</script>

</body>
</html>
