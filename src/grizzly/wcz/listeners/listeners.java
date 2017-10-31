package grizzly.wcz.listeners;

import org.bukkit.Bukkit;
import org.bukkit.ChatColor;
import org.bukkit.Material;
import org.bukkit.entity.ArmorStand;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.entity.EntityCombustEvent;
import org.bukkit.event.inventory.InventoryClickEvent;
import org.bukkit.event.inventory.InventoryType;
import org.bukkit.event.player.AsyncPlayerChatEvent;
import org.bukkit.event.player.PlayerJoinEvent;
import org.bukkit.inventory.ItemStack;

public class listeners implements Listener {
	//�ж���Ʒlore�Ƿ���"��л�������"
	@EventHandler
	public void onAnvil(InventoryClickEvent event) {
	    if (event.getRawSlot() == 2 && event.getWhoClicked() instanceof Player && event.getInventory().getType() == InventoryType.ANVIL) {
	    	ItemStack stack = event.getInventory().getContents()[0];
	    	if (stack != null && stack.getType() != Material.AIR && stack.hasItemMeta() && stack.getItemMeta().hasLore()) {
	    		 if (ChatColor.stripColor(stack.getItemMeta().getLore().toString()).contains("��л�������") || ChatColor.stripColor(stack.getItemMeta().getLore().toString()).contains("�޷���������")) {
	    			event.setCancelled(true);
	    		}
	    	}
	    }
	}
	//ȡ�����׼��Ż�
	@EventHandler
	public void onArmorStand(EntityCombustEvent event) {
		if (event.getEntity() instanceof ArmorStand) {
			event.setCancelled(true);
		}
	}
	//������Ϣ��ʾ
	@EventHandler
	public void onPlayerJoin(PlayerJoinEvent p) {
		if (p.getPlayer().hasPermission("vipjoin.1")) {
			p.setJoinMessage(null);
			Bukkit.broadcastMessage("��b��l��m                                                         ");
			Bukkit.broadcastMessage("��a��l        ��e����"+ p.getPlayer().getName() +"��a��Ҽ�������Ϸ  ");
			Bukkit.broadcastMessage("��b��l��m                                                         ");
			return;
		}
	}
	//��ֹĳ���緢��
	@EventHandler
	public void onWorld(AsyncPlayerChatEvent e) {
		Player p = e.getPlayer();
		if (p.getWorld().getName().contains("world_him")) {
			p.sendMessage("��7Him��ס��������");
			p.sendMessage("��7�ȴ���Him֧���");
			e.setCancelled(true);
		}
	}
	//�����������ɹ���
	@EventHandler
	public void onRandomSpawn() {
		
	}
}
