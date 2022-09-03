if exist "Public" (
  php -S localhost:8888 -t "Public"
) else (
  php -S localhost:8888 -t "\"
)