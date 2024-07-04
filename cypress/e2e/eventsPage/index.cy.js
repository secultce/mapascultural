describe("Events Page", () => {
  beforeEach(() => {
    cy.viewport(1920, 1080);
    cy.visit("/eventos");
  });

  it("Garantir que após clicar em \"Eventos\" consiga carregar a página com a seção dos eventos e a seção de filtros, cada filtro com o valor padrão", () => {
    cy.contains("a", "Eventos").click();
    cy.get(".search-filter__actions--form-input").should("exist").and("be.empty");
    cy.get("select").should("exist");
  });

  it("Garantir que é possível clicar em \"Eventos acontecendo\" na caixa de filtragem e que ao fazê-lo, um calendário é exibido, juntamente com opções rápidas de busca na lateral direita", () => {
    cy.contains("a", "Eventos").click();
    cy.contains("Eventos acontecendo").should("exist");
    cy.get(".dp__pointer").click();
    cy.get(".dp__menu_content_wrapper").should("exist");
    cy.get(".dp__preset_ranges").should("exist");
    cy.get(".dp__flex_display").should("exist");
    ["Hoje", "Amanhã", "Esta semana", "Este fim de semana", "Próximo fim de semana", "Próximos 7 dias", "Próximos 30 dias", "2024"].forEach(dateRange => {
      cy.contains(dateRange).should("exist");
    });
  });

  it("Garantir que nas opções rápidas, seja possível clicar na opção \"2024\"", () => {
    cy.contains("a", "Eventos").click();
    cy.contains("Eventos acontecendo").click();
    cy.get(".dp__pointer").click();
    cy.contains("2024").click();
    cy.get(".filter-btn > :first-child").should("exist");
  });

  it("Garantir de que, após clicar na opção \"2024\", é possível clicar na seta de navegação esquerda, filtrando para o ano de \"2023\"", () => {
    cy.get(".dp__pointer").click();
    cy.contains("2024").click();
    cy.get(".filter-btn > :first-child").click();
  });

  it("Garantir de que, após clicar na opção \"2024\", é possível clicar na seta de navegação direita, filtrando para o ano de \"2025\"", () => {
    cy.get(".dp__pointer").click();
    cy.contains("2024").click();
    cy.get(".filter-btn > :last-child").should("exist");
  });

  it("Garantir que é possível acessar um evento e carregar as informações", () => {
    cy.get(".dp__pointer").click();
    cy.contains("2024").click();
    cy.get(".filter-btn > :first-child").click();
    cy.visit("/evento/1");
    cy.contains("h1", "Evento de Cultura");
    cy.contains("p", "Este é um evento incrível organizado por todos.");
    cy.get(".tabs__info").should("exist");
  });
});
