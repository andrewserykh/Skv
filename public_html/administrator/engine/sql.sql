DROP PROCEDURE `upd_ord_st`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_ord_st`(st int, cid int)
begin
  update orders set status_id=st where car_id=cid;
end

create trigger tr_status after update on car
     for each row begin
     call upd_ord_st (new.status_id, new.id);
     
     end
	 
	 