# Sobre o Projeto

Este projeto foi desenvolvido como parte do trabalho e avaliação dos conhecimentos adquiridos durante a situação de aprendizagem (SA) da unidade curricular (UC) de Desenvolvimento de Sistemas.

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

Existem duas maneiras de testar o projeto localmente: via **XAMPP/WAMP** ou **Docker**.

## 1. Via XAMPP/WAMP

Caso você tenha o **XAMPP** ou **WAMP** instalado em sua máquina, siga os passos abaixo:

1. Inicialize o **XAMPP/WAMP**.
2. Clone o repositório na **branch main**.
3. Certifique-se de que o projeto está localizado na pasta `WWW` (para WAMP) ou `HTDOCS` (para XAMPP).
4. Abra seu navegador e acesse a URL:

    ```
    http://localhost/GePadariaMbembe
    ```

---

## 2. Via Docker (Recomendado)

Se você tem o **Docker** instalado, essa é a maneira mais simples e recomendada para testar o projeto. Siga os passos abaixo:

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

# Contribuições

Se você deseja contribuir com o projeto, siga os seguintes passos:

1. Faça um fork deste repositório.
2. Crie uma branch para a sua modificação (`git checkout -b minha-branch`).
3. Commit suas alterações (`git commit -am 'Adiciona nova funcionalidade'`).
4. Envie para o repositório remoto (`git push origin minha-branch`).
5. Abra um pull request!

---

# Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE).
