"""Domain models for an appointment scheduler, using pure SQLAlchemy."""

from datetime import datetime

from sqlalchemy import Column, ForeignKey
from sqlalchemy import Boolean, DateTime, Integer, String, Text
from sqlalchemy.dialects.postgresql import JSON, JSONB
from sqlalchemy.ext.declarative import declarative_base


Base = declarative_base()

class ReglementaryCost(Base):
    """docstring for ReglementaryCosts"""
    __tablename__ = 'reglementarycost'

    id = Column(Integer, primary_key=True)
    placecost = Column(Integer)
    fga = Column(Integer)
    tuca = Column(Integer)
    drecours = Column(JSONB)
    ranticipe = Column(JSONB)
    rcivile = Column(JSONB)


class Quotation(Base):
    """An appointment on the calendar."""
    __tablename__ = 'quotation'

    id = Column(Integer, primary_key=True)
    name = Column(String(255))
    description = Column(Text)

    iconducteur = Column(Integer)
    brisglace = Column(Integer)
    incendie = Column(Integer)
    volvag = Column(Integer)
    volacc = Column(Integer)
    domveh = Column(Integer)
    domcol = Column(Integer)
    accessoire = Column(Integer)
    vandalisme = Column(Integer)
    permis = Column(Integer)
    catsopo = Column(Integer)
    reducom = Column(Integer) #This param sounds problematic

    #gbase = Column(JSONB)
    #tsimple = Column(JSONB)
    #tcomp = Column(JSONB)
    #tcol = Column(JSONB)
    #trisque = Column(JSONB)
    #
    def rc_frac(self,rc, periode):
        if periode:
            return rc*0.1 + (periode -1)*0.09
        return 0

    def fga(self,rc,periode):
        return self.rc_frac(rc,periode)*0.02

    def bris_glace(self,vneuve):
        return self.brisglace*vneuve

    def incend(self,vvenale):
        return self.incendie * vvenale

    def vol_vag(self, vvenale):
        return self.volvag*vvenale

    def vol_acc(self):
        return self.volacc

    def dom_veh(self,vneuve):
        return self.domveh*vneuve

    def dom_col(self, vneuve):
        return self.domcol*vneuve

    def accessoire_(self):
        return self.accessoire

    def vandalisme_(self):
        return self.vandalisme

    def reduc_permis(self, rc):
        return self.permis *rc

    def reduc_catsopo(self, rc):
        return self.catsopo*rc


    def __repr__(self):
        return u'<{self.__class__.__name__}: {self.name}>'.format(self=self)


if __name__ == '__main__':
    import sqlalchemy
    from datetime import timedelta

    from sqlalchemy import create_engine
    from sqlalchemy.orm import sessionmaker

    # This uses a SQLite database in-memory.
    #
    # That is, this uses a database which only exists for the duration of
    # Python's process execution, and will not persist across calls to Python.
    engine = create_engine("postgresql://postgres:cat@localhost/postgres", echo=True)

    # Create the database tables if they do not exist, and prepare a session.
    #
    # The engine connects to the database & executes queries. The session
    # represents an on-going conversation with the database and is the primary
    # entry point for applications to use a relational database in SQLAlchemy.
    Base.metadata.create_all(engine)
    Session = sessionmaker(bind=engine)
    session = Session()


    # Add some sample appointments.
    session.add(ReglementaryCost(
        placecost = 2500,
        fga = 0.02,
        tuca = 0,
        drecours = {"norm": 7950,
                    "execpt": 4240},
        ranticipe = {"norm": 7950,
                    "execpt": 0},
        rcivile = {"cat1": {
                                "zone1": {
                                        "essence": {
                                                        "1": 58675,
                                                        "2": 58675,
                                                        "3": 66885,
                                                        "4": 66885,
                                                        "5": 66885,
                                                        "6": 66885,
                                                        "7": 73415,
                                                        "8": 73415,
                                                        "9": 73415,
                                                        "10": 114693,
                                                        "11": 114693,
                                                        "12": 129058
                                                    },
                                        "diesel":   {
                                                        "1": 58675,
                                                        "2": 66885,
                                                        "3": 66885,
                                                        "4": 66885,
                                                        "5": 73415,
                                                        "6": 73415,
                                                        "7": 114693,
                                                        "8": 114693,
                                                        "9": 114693
                                                    }
                                        },
                            "zone2": {
                                        "essence": {
                                                        "1": 55541,
                                                        "2": 55541,
                                                        "3": 63541,
                                                        "4": 63541,
                                                        "5": 63541,
                                                        "6": 63541,
                                                        "7": 69744,
                                                        "8": 69744,
                                                        "9": 69744,
                                                        "10": 108958,
                                                        "11": 108958,
                                                        "12": 122605
                                                    },
                                        "diesel":   {
                                                        "1": 55741,
                                                        "2": 63541,
                                                        "3": 63541,
                                                        "4": 63541,
                                                        "5": 69744,
                                                        "6": 69744,
                                                        "7": 108958,
                                                        "8": 108958,
                                                        "9": 122605
                                                    }
                                        },
                            "zone3": {
                                        "essence": {    "1": 52808,
                                                        "2": 52808,
                                                        "3": 60197,
                                                        "4": 60197,
                                                        "5": 60197,
                                                        "6": 60197,
                                                        "7": 66074,
                                                        "8": 66074,
                                                        "9": 66074,
                                                        "10": 103224,
                                                        "11": 103224,
                                                        "12": 116152
                                                    },
                                        "diesel":   {
                                                        "1": 52808,
                                                        "2": 60197,
                                                        "3": 60197,
                                                        "4": 60197,
                                                        "5": 66074,
                                                        "6": 66074,
                                                        "7": 103224,
                                                        "8": 103224,
                                                        "9": 116152
                                                    }
                                    }
                            }
                        }))
    session.commit()

    session.add(Quotation(
        name='Aroli Courtage',
        description = "Compte Aroli",
        iconducteur = 10000,
        brisglace = 0.003,
        incendie = 0.007,
        volvag = 0.018,
        volacc = 25000,
        domveh = 0.07,
        domcol = 0.055,
        accessoire = 10000,
        vandalisme = 10000,
        permis = 0.05,
        catsopo = 0.05,
        reducom = 0
        #gbase = [],
        #tsimple = [],
        #tcomp = [],
        #tcol = [],
        #trisque = []
        ))
    session.commit()

    quot = session.query(Quotation).get(1)
    print(quot)

    # Get all appointments.
    quots = session.query(Quotation).all()
    print(quots)

    q=session.query(ReglementaryCost).filter(ReglementaryCost.rcivile[('cat1','zone1', "essence", "11")].astext.cast(Integer) == 114693).first()
    print("### ",q)

    q=session.query(ReglementaryCost).filter(ReglementaryCost.rcivile[('cat1','zone1', "essence", "11")]).first()
    print("### ",q)

    #q=session.query(Quotation).filter(Quotation.rcivile[('base','rc')].astext.cast(Integer) == 5678).first()
    #print("### ",q)

    # Get all appointments before right now, after right now.
    #appts = session.query(Quotation).filter( Quotation.policy[
    #        ('address', 'zip')
    #    ].cast(sqlalchemy.Integer) == 5678).one()
    #print(appts)
