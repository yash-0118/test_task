<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #1e88e5;
        }

        a:hover {
            text-decoration: underline;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
            font-size: 14px;
        }

        button {
            padding: 5px 15px;
            background-color: #1e88e5;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0d47a1;
        }

        .dropdown {
            display: inline-block;
            position: relative;
            margin-left: 10px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        .show {
            display: block;
        }
    </style>
</head>

<body>
    <h1>Latest News</h1>
    <div>
        <input type="text" id="searchInput" placeholder="Search news...">
        <button onclick="searchNews()">Search</button>
        <button onclick="clearSearch()">Clear</button>
        <div class="dropdown">
            <button onclick="toggleDropdown()" class="dropbtn">Sort By Date</button>
            <div id="myDropdown" class="dropdown-content">
                <a onclick="sortNews('asc')">Ascending</a>
                <a onclick="sortNews('desc')">Descending</a>
            </div>
        </div>
    </div>
    <table id="newsTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th>Publish Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allNews as $news)
            <tr>
                <td>{{$news['title']}}</td>
                <td><a href="{{$news['link']}}" target="_blank">Know more</a></td>
                <td>{{$news['pubDate']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function searchNews() {
            let keyword = document.getElementById('searchInput').value.trim();
            fetchNews(keyword, null); 
        }

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            fetchNews('', null); 
        }

        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        function sortNews(order) {
            fetchNews('', order); 
            toggleDropdown(); 
        }

        function fetchNews(keyword, order) {
            $.ajax({
                url: "{{ route('fetch.news') }}",
                method: 'GET',
                data: {
                    keyword: keyword,
                    order: order
                },
                success: function(response) {
                    $('#newsTable tbody').html(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }


        $(document).on('click', function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        });
    </script>
</body>

</html>