
package ModeloDAO;

import Config.Conexion;
import Interfaces.interfaceCliente;
import Modelo.Cliente;
import java.sql.*;
/**
 *
 * @author Mario
 */
public class ClienteDAO implements interfaceCliente {
Conexion cn = new Conexion();
    Connection con;
    @Override
    public boolean registrar(Cliente cliente) {
        String sql = "{CALL registrarCliente(?, ?, ?, ?, ?, ?, ?)}";
        try {
            con = cn.getConnection();
            CallableStatement cs = con.prepareCall(sql);
            cs.setString(1, cliente.getNombre());
            cs.setString(2, cliente.getApellido());
            cs.setString(3, cliente.getDireccion());
            cs.setString(4, cliente.getTelefono());
            cs.setString(5, cliente.getUsuario());
            cs.setString(6, cliente.getClave());
            cs.setBytes(7, cliente.getImg_usuario());
            cs.execute();
            return true;
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
    }

    @Override
    public Cliente autenticar(String usuario, String clave) {
       String sql = "{CALL autenticarCliente(?, ?)}";
        Cliente cliente = null;
        try {
            con = cn.getConnection();
            CallableStatement cs = con.prepareCall(sql);
            cs.setString(1, usuario);
            cs.setString(2, clave);
            ResultSet rs = cs.executeQuery();
            if (rs.next()) {
                cliente = new Cliente();
                cliente.setId_cliente(rs.getInt("id_cliente"));
                cliente.setNombre(rs.getString("nombre"));
                cliente.setApellido(rs.getString("apellido"));
                cliente.setDireccion(rs.getString("direccion"));
                cliente.setTelefono(rs.getString("telefono"));
                cliente.setUsuario(rs.getString("usuario"));
                cliente.setClave(rs.getString("clave"));
                cliente.setImg_usuario(rs.getBytes("img_usuario"));
            }
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Error al autenticar el cliente: " + e.getMessage());
        }
        return cliente;
    }

    @Override
    public boolean actualizar(Cliente cliente) {
       String sqlConImagen = "{CALL actualizarCliente(?, ?, ?, ?, ?, ?, ?, ?)}";
    String sqlSinImagen = "{CALL actualizarCliente(?, ?, ?, ?, ?, ?, ?, NULL)}"; // Aquí ajustamos para pasar NULL cuando no hay imagen
    try {
        con = cn.getConnection();
        CallableStatement cs = con.prepareCall(cliente.getImg_usuario() != null ? sqlConImagen : sqlSinImagen);
        cs.setInt(1, cliente.getId_cliente());
        cs.setString(2, cliente.getNombre());
        cs.setString(3, cliente.getApellido());
        cs.setString(4, cliente.getDireccion());
        cs.setString(5, cliente.getTelefono());
        cs.setString(6, cliente.getUsuario());
        if (cliente.getClave() != null && !cliente.getClave().isEmpty()) {
            cs.setString(7, cliente.getClave());
        } else {
            cs.setNull(7, java.sql.Types.VARCHAR);
        }
        if (cliente.getImg_usuario() != null) {
            cs.setBytes(8, cliente.getImg_usuario());
        }
        int rowsAffected = cs.executeUpdate();
        return rowsAffected > 0;
    } catch (Exception e) {
        e.printStackTrace();
        System.out.println("Error al actualizar el cliente: " + e.getMessage());
        return false;
    }
    }

}
