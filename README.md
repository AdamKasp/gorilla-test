## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.


## Comments

przetłumaczyłem `przegląd` jako `technicalReview`, oraz `zgłoszenie awarii` jako `crashReport` ale TBH normalnie upewniłbym się z domain expertem jak to nazwać :D


====

Dane źródłowe to zbiór „wiadomości” znajdujących się w pliku recruitment-task-source.json.
Wynikiem przetworzenia zbioru mają być byty typu „zgłoszenie awarii” oraz „przegląd”.
Pola bytu “przegląd”:
● opis
● typ (przegląd)
● data przeglądu (Y-m-d)
● tydzień w roku daty przeglądu
● status
● zalecenia dalszej obsługi po przeglądzie
● numer telefonu osoby do kontaktu po stronie klienta
● data utworzenia
Pola bytu “zgłoszenie awarii”:
● opis
● typ (zgłoszenie awarii)
● priorytet
● termin wizyty serwisu (Y-m-d)
● status
● uwagi serwisu
● numer telefonu osoby do kontaktu po stronie klienta
● data utworzenia
Należy przetworzyć zbiór w następujący sposób:
● jeśli w polu `description` znajdziemy frazę `przegląd` kwalifikujemy byt jako przegląd, jeśli
nie, wówczas jako zgłoszenie awarii,
● dla typu przegląd, jeśli jesteśmy w stanie określić `dueDate`, po przetworzeniu musimy mieć
też dane na temat tygodnia w roku dla tej daty oraz w tej sytuacji, status przeglądu to
`zaplanowano`, jeśli data ta jest nieokreślona, wówczas status to `nowy`


● jeśli wiadomość zawiera w polu `description` frazę `bardzo pilne`, to jest to dla nas priorytet
`krytyczny`, jeśli zawiera frazę `pilne` - potraktujmy to jako priorytet `wysoki`, jeśli nie zawiera
powyższych słów – wówczas jest to dla nas priorytet `normalny`
● jeśli wiadomość kwalifikujemy jako zgłoszenie awarii, wówczas `dueDate` jest terminem
wizyty serwisu, jeśli zajdzie taka okoliczność wówczas status określamy jako `termin`, w
przeciwnym razie jako `nowy`
● jeśli wystąpi duplikat według pola `description`, wówczas kolejnego bytu na jego podstawie
już nie tworzymy
● odpowiednikiem pola `numer telefonu osoby do kontaktu po stronie klienta` w pliku
źródłowym jest pole `phone`
● pola bytów, dla których nie mamy podstaw by je wypełnić zostawiamy puste
Przetwarzanie zbioru powinno być inicjowane za pośrednictwem wywołania polecenia z linii
komend wraz ze wskazaniem pliku źródłowego.
Wynikiem działania powinny by być dwa pliki .json, gdzie w jednym będą znajdowały się jedynie byty
typu zgłoszenie awarii, a w drugim przeglądy.
Dodatkowo po wykonaniu polecenia, w konsoli powinniśmy zobaczyć czytelne podsumowanie
mówiące o ogólnej liczbie przetworzonych wiadomości, o ilości utworzonych przeglądów, osobno
zgłoszeń.

Podsumowanie powinno zawierać wartości `number` wraz ze stosownym komentarzem dla tych
wiadomości których przetworzenie nie było możliwe. Wiadomości te powinniśmy zobaczyć w trzecim
pliku wynikowym, w oryginalnym o formacie. Istotne momenty w działaniu aplikacji powinny być
zalogowane.
