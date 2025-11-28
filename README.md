# Sobre o Projeto

Este projeto foi desenvolvido como parte do trabalho e avaliação dos conhecimentos adquiridos durante a situação de aprendizagem (SA) da unidade curricular (UC) de Desenvolvimento de Sistemas.

## Desenvolvedores
### [@micaeljunco](https://github.com/micaeljunco)
### [@Carlos-Yan0](https://github.com/Carlos-Yan0)
### [@Freitas014](https://github.com/Freitas014)
### [@Lucas-Magalhaes-oficial](https://github.com/Lucas-Magalhaes-oficial)
---

# Estrutura e Tecnologias Utilizadas

Para o desenvolvimento deste projeto, utilizamos as seguintes tecnologias:

- **PHP**: Para a criação da lógica de backend.
- **HTML5**: Para estruturação do conteúdo da página.
- **CSS3**: Para o estilo visual da aplicação.
- **Bootstrap**: Para componentes prontos.
- **JavaScript**: Para interatividade e validação de dados no frontend.

A arquitetura de software adotada é o **MVC** (Model-View-Controller), o que garante uma maior organização, manutenibilidade e eficiência na produção do projeto.

---

# Como Testar o Projeto

Existem Três maneiras de testar o projeto localmente: via **XAMPP/WAMP** ou **Docker**.

## 1. Via Site (recomendado para recrutadores)

A forma mais simples de testar é acessar a versão hospedada:

 ```
    https://gepadariambembe.infinityfreeapp.com
 ```


## 2. Via XAMPP/WAMP

Caso você tenha o **XAMPP** ou **WAMP** instalado em sua máquina, siga os passos abaixo:

1. Inicialize o **XAMPP/WAMP**.
2. Clone o repositório na **branch main**.
3. Certifique-se de que o projeto está localizado na pasta `WWW` (para WAMP) ou `HTDOCS` (para XAMPP).
4. Abra seu navegador e acesse a URL:

    ```
    http://localhost/GePadariaMbembe
    ```

---

## 3. Via Docker (recomendado para devs)

Se você tem o **Docker** instalado, essa é a maneira mais simples e recomendada para devs testarem o projeto. Siga os passos abaixo:

1. Clone o repositório e troque para a **branch docker**.
2. Com o terminal, navegue até a pasta onde o projeto foi clonado.
3. Execute o seguinte comando:

    ```bash
    docker-compose up -d
    ```

4. Após o comando ser executado, abra o seu navegador e acesse a URL:

    ```
    http://localhost:8080
    ```

O projeto será inicializado sem problemas.

---

# Como Fazer Login no Sistema?

Para realizar o login no sistema, é necessário utilizar um **e-mail** e uma **senha** pré-definidos. Essas credenciais podem ser encontradas no arquivo **`LOGINS`** que acompanha o projeto.

---

# Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE).
