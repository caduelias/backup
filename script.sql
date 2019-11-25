create table combustivel(idcombustivel integer primary key , descricao varchar(30));

insert into combustivel(idcombustivel, descricao) values (1,'Etanol'), (2,'Gasolina');

create table historico
(
    idhistorico    int not null primary key auto_increment,
    idcombustivel  int   null,
    comparacao     float null,
    valor          float null,
    data           date  null,
    foreign key (idcombustivel) references combustivel (idcombustivel)
);
