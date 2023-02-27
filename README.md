TEST TECNICO ZYLA
Se realizo API que guarde en una base de datos (MySQL) informacion del clima actual de una ciudad.
Las consultas retorna de una api de terceros proporcionada (https://weatherstack.com/).

Se trabajo con un modelo MVC, se realizo la migracion de 3 tablas debido a la naturaleza dinamica de los datos era preferible mantener la localizacion y solo actualizar los current que se iban consultando, de esta manera ademas de ahorrar tiempo de consulta es posible tener mayor escalabilidad y se decidio realizar asignaciones masivas con filiables en sus respectivos modelos.

Funciones: logica, store y update

Se puede consumir la api con la siguiente URL.

sh
url('http://127.0.0.1:8000/api/current/New York')

Se debe agregar al env las siguientes variables globales

'WEATHERSTACKk_URL'
'WEATHERSTACKk_API_kEY'
