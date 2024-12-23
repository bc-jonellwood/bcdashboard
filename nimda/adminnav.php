<nav>
    <ul class="adminnav">
        <li><button class='not-btn' value='edit-links' onclick=showDiv(this.value)>Edit Links</button></li>
        <li><button class='not-btn' value='add-links' onclick=showDiv(this.value)>Add Links</button></li>
        <li><button class='not-btn' value='other-things' onclick=showDiv(this.value)>Other Things</button></li>

    </ul>
</nav>

<script>
    function showDiv(value) {
        var divs = document.getElementsByClassName('hidden');
        for (var i = 0; i < divs.length; i++) {
            divs[i].style.display = 'none';
        }
        var div = document.getElementsByClassName(value)[0];
        div.style.display = 'block';
    }
</script>

<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .adminnav {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        margin-top: 20px;
        margin-left: 50px;
        margin-right: 50px;
    }
</style>