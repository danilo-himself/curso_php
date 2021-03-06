use dbphp7;

CREATE TABLE tb_usuarios(
idusuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
deslogin VARCHAR(64) NOT NULL,
dessenha VARCHAR(256) NOT NULL,
dtcadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()

);

INSERT INTO tb_usuarios(deslogin, dessenha) VALUES ('root','123');

SELECT * FROM tb_usuarios;

UPDATE tb_usuarios SET dessenha = '123456' WHERE idusuario = 1;

DELETE FROM tb_usuarios WHERE idusuario = 1;

TRUNCATE table tb_usuarios;

DELIMITER //

CREATE PROCEDURE sp_usuarios_insert (IN pdeslogin VARCHAR(64), IN pdessenha VARCHAR(256))
 BEGIN
  INSERT INTO tb_usuarios (deslogin, dessenha) VALUES (pdeslogin, pdessenha);
  SELECT * FROM tb_usuarios WHERE idusuario = LAST_INSERT_ID();
 END;
//

DELIMITER ;