describe('Diagnóstico Avançado de Ambiente Laravel', () => {
    it('Deve reportar o ambiente e o banco de dados corretos de todas as fontes', () => {
        cy.request('/debug-env').then((response) => {
            cy.log('Ambiente App:', response.body.ambiente_app);
            cy.log('Banco de Dados (via DB Facade):', response.body.banco_de_dados_via_db);
            cy.log('Banco de Dados (via Config Helper):', response.body.banco_de_dados_via_config);

            expect(response.body.ambiente_app).to.equal('testing');
            expect(response.body.banco_de_dados_via_config, "Verificação da Configuração Direta").to.equal('taskmanager_test');
            expect(response.body.banco_de_dados_via_db, "Verificação da Conexão Ativa").to.equal('taskmanager_test');
        });
    });
});
