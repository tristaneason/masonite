        <script>
            document.querySelector('#videos .video:first-child').classList.remove('hidden');
            document.querySelector('#videos .video:first-child').classList.add('active');

            var links = document.querySelectorAll('#videos .video');
            for (var i = 0; i < links.length; i++) {
                links[i].addEventListener('click', function() {
                    document.querySelector('.active').classList.add('hidden');
                    document.querySelector('.active').classList.remove('active');
                    this.classList.remove('hidden');
                    this.classList.add('active');
                });
            }
        </script>
    </body>
</html>
